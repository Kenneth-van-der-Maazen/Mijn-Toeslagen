<?php
require "../includes/user-class.php";
// require_once __DIR__ . '/../includes/db.php';

$pageTitle = "Registreren - Dienst Toeslagen";
$error = "";

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = new User();

        $email          = htmlspecialchars($_POST['email']);
        $password       = htmlspecialchars($_POST['password']);
        $confirm        = htmlspecialchars($_POST['confirm_password']);
        $naam           = htmlspecialchars($_POST['naam']);
        $adres          = htmlspecialchars($_POST['adres']);
        $woonplaats     = htmlspecialchars($_POST['woonplaats']);
        $geboortedatum  = htmlspecialchars($_POST['geboortedatum']);
        $inkomen        = htmlspecialchars($_POST['inkomen']);
        $gezinsgrootte  = htmlspecialchars($_POST['gezinsgrootte']);

        if ($password !== $confirm) {
            $error = "Wachtwoorden komen niet overeen.";
        } else {
            $stmt = $sql->registerUser(
                $email, $password, $naam, $adres, $woonplaats,
                $geboortedatum, (float)$inkomen, (int)$gezinsgrootte
            );
            
            echo "<div class='alert alert-success mt-3'>Registratie gelukt! Welkom $naam, U wordt nu doorgestuurd...</div>";
            header("refresh:3, url = login.php");
            exit;
        }
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger mt-3'>Er is een fout opgetreden: " . $e->getMessage() . "</div>";
}


// $db  = new Database();
// $pdo = $db->getConnection();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $username = trim($_POST['username']); // maps to 'naam'
//     $email    = trim($_POST['email']);
//     $password = $_POST['password'];

//     try {
//         // Ensure 'gebruiker' role exists and get its id
//         $stmt = $pdo->prepare("SELECT rol_id FROM Rollen WHERE naam = :naam");
//         $stmt->execute(['naam' => 'gebruiker']);
//         $rolId = $stmt->fetchColumn();

//         if (!$rolId) {
//             $pdo->prepare("INSERT INTO Rollen (naam) VALUES ('gebruiker')")->execute();
//             $rolId = (int)$pdo->lastInsertId();
//         }

//         // Insert gebruiker
//         $stmt = $pdo->prepare("
//             INSERT INTO Gebruikers (rol_id, email, wachtwoord_hash, naam)
//             VALUES (:rol_id, :email, :wachtwoord_hash, :naam)
//         ");
//         $stmt->execute([
//             'rol_id'          => $rolId,
//             'email'           => $email,
//             'wachtwoord_hash' => password_hash($password, PASSWORD_DEFAULT),
//             'naam'            => $username,
//         ]);

//         header("Location: Login.php");
//         exit;
//     } catch (PDOException $e) {
//         $error = "Registratie mislukt: " . htmlspecialchars($e->getMessage());
//     }
// }

// include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account maken</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .hidden { display: none; }
        .fade-in { animation: fadeIn 0.5s ease-in-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="container mt-5">


    <h2>Account registratie</h2>

    <form method="POST" id="registerForm" class="mt-3">

        <!-- Stap 1 -->
        <div id="step1">
            <div class="mb-3"><input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required></div>
            <div class="mb-3"><input type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord" required></div>
            <div class="mb-3"><input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Herhaal wachtwoord" required></div>
            <button type="button" id="nextBtn" class="btn btn-primary">Volgende</button>
        </div>

        <!-- Stap 2 -->
        <div id="step2" class="hidden">
            <div class="mb-3"><input type="text" name="naam" class="form-control" placeholder="Naam" required></div>
            <div class="mb-3"><input type="text" name="adres" class="form-control" placeholder="Adres" required></div>
            <div class="mb-3"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" required></div>
            <div class="mb-3"><input type="date" name="geboortedatum" class="form-control" required></div>
            <div class="mb-3"><input type="number" name="inkomen" class="form-control" placeholder="Inkomen" required></div>
            <div class="mb-3"><input type="number" name="gezinsgrootte" class="form-control" placeholder="Gezinsgrootte" required></div>
            <button type="submit" class="btn btn-success">Registreren</button>
        </div>
    </form>

    <p class="mt-3"><a href="user-login.php">Inloggen met een bestaand account?</a></p>

    <script>
        const nextBtn = document.getElementById('nextBtn');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');

        nextBtn.addEventListener('click', function() {
            const email = document.getElementById('email').value.trim();
            const pw = document.getElementById('password').value.trim();
            const cpw = document.getElementById('confirm_password').value.trim();

            // Basiscontrole voordat we doorgaan
            if (!email || !pw || !cpw) {
                alert('Vul alle velden in.');
                return;
            }
            if (pw !== cpw) {
                alert('Wachtwoorden komen niet overeen.');
                return;
            }
            if (!email.includes('@')) {
                alert('Voer een geldig e-mailadres in.');
                return;
            }

            // Toon stap 2
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            step2.classList.add('fade-in');
        });
    </script>

<?php // include('../includes/footer.php'); ?>