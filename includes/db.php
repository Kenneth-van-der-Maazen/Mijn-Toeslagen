<?php

class Database {
    protected $pdo;

    public function __construct($db = "mysql:host=localhost;dbname=ToeslagenDB;charset=utf8mb4", $user = "root", $pass = "") {
        try {
            $this->pdo = new PDO($db, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }


    public function execute($sql, $placeholders = []) {
        if (empty($placeholders)) {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt;
    }
}
?>