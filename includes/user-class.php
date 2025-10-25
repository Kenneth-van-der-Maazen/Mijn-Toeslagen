<!-- Kenneth -->
<?php
require_once 'db.php';

class User {
    private $db;

    public function __construct() {
        $this->pdo = new Database();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Functie om nieuwe gebruikers te registreren
    public function registerUser(
        string $email, 
        string $password,
        string $naam,
        string $adres,
        string $woonplaats,
        string $geboortedatum,
        float $inkomen,
        int $gezinsgrootte
    ) {
        $stmt = $this->pdo->execute("SELECT rol_id FROM rollen WHERE naam = 'gebruiker' LIMIT 1");
        $rolId = $stmt->fetchColumn();

        if (!$rolId) {
            $this->pdo->execute("INSERT INTO rollen (naam) VALUES ('gebruiker')");
            $rolId = $this->pdo->execute("SELECT LAST_INSERT_ID()")->fetchColumn();
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $this->pdo->execute(
            "INSERT INTO gebruikers 
                (rol_id, email, wachtwoord_hash, naam, adres, woonplaats, geboortedatum, inkomen, gezinsgrootte, actief)
            VALUES 
                (:rol_id, :email, :password, :naam, :adres, :woonplaats, :geboortedatum, :inkomen, :gezinsgrootte, 1)",
            [
                ':rol_id'        => $rolId,
                ':email'         => $email,
                ':password'      => $hash,
                ':naam'          => $naam,
                ':adres'         => $adres,
                ':woonplaats'    => $woonplaats,
                ':geboortedatum' => $geboortedatum,
                ':inkomen'       => $inkomen,
                ':gezinsgrootte' => $gezinsgrootte
            ]);
        }

    // Inloggen met een e-mail adres
    public function getUserByEmail(string $email) {
        $stmt = $this->pdo->execute(
            "SELECT * FROM gebruikers WHERE email = :email LIMIT 1",
            [':email' => $email]
        );
        return $stmt->fetch();
    }

    // Login met naam en wachtwoord
    public function login($name, $password) {
        $stmt = $this->pdo->execute("SELECT * FROM gebruikers WHERE naam = :naam LIMIT 1", [':naam' => $name]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['wachtwoord_hash'])) {
            // user opslaan in session
            $_SESSION['gebruiker_id'] = $user['gebruiker_id'];
            $_SESSION['naam'] = $user['naam'];
            $_SESSION['logged_in'] = true;
            return true;
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function logout() {
        session_destroy();
        $_SESSION = [];
    }


    // Gegevens ophalen van de gebruiker via user_id
    public function getUserById(int $gebruiker_id) {
        $stmt = $this->pdo->execute(
            "SELECT * FROM gebruikers WHERE gebruiker_id = :id LIMIT 1",
            [':id' => $gebruiker_id]
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Bijwerken gegevens van gebruiker
    public function updateUser(int $gebruiker_id, string $naam, string $adres, string $woonplaats) {
        $this->pdo->execute(
            "UPDATE gebruikers 
            SET naam = :naam, adres = :adres, woonplaats = :woonplaats 
            WHERE gebruiker_id = :id",
            [
                ':naam' => $naam,
                ':adres' => $adres,
                ':woonplaats' => $woonplaats,
                ':id' => $gebruiker_id
            ]
        );
    }

    // Alle gebruikers ophalen
    public function getAllUsers() {
        $stmt = $this->pdo->execute(
            "SELECT * FROM gebruikers ORDER BY naam ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Alle toeslagen van een gebruiker ophalen (met koppeling naar toeslagen-tabel)
    public function getUserToeslagen(int $gebruiker_id) {
        $sql = "
            SELECT 
                ut.id AS user_toeslag_id,
                ut.gebruiker_id,
                ut.toeslag_id,
                t.naam AS toeslag_naam,
                t.beschrijving AS toeslag_beschrijving,
                ut.actief,
                ut.bedrag,
                ut.jaar,
                ut.aangemaakt_op,
                ut.bijgewerkt_op
            FROM user_toeslagen ut
            INNER JOIN toeslagen t 
                ON ut.toeslag_id = t.toeslag_id
            WHERE ut.gebruiker_id = :gebruiker_id
            ORDER BY ut.jaar DESC, t.naam ASC
        ";

        $stmt = $this->pdo->execute($sql, [':gebruiker_id' => $gebruiker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Functie om alle uitbetalingen te weergeven
    public function getUserPayments(int $gebruiker_id, int $jaar = null): array {
        if ($jaar === null) {
            $jaar = date('Y');
        }

        $sql = "
            SELECT 
                u.betaling_id,
                u.bedrag,
                u.toeslag_id,
                u.date,
                u.rekening,
                u.omschrijving,
                t.naam AS toeslag_naam
            FROM uitbetalingen u
            LEFT JOIN toeslagen t 
                ON u.toeslag_id = t.toeslag_id
            WHERE u.gebruiker_id = :gebruiker_id
            AND YEAR(u.date) = :jaar
            ORDER BY u.date DESC
        ";

        $stmt = $this->pdo->execute($sql, [
            ':gebruiker_id' => $gebruiker_id,
            ':jaar' => $jaar
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>