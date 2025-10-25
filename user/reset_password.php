<?php
require_once __DIR__ . '/../includes/db.php';

session_start();

$db  = new Database();
$pdo = $db->getConnection();

$token = $_GET['token'] ?? '';
$error = $success = '';
$valid = false;
$uid = null;

if ($token) {
    try {
        // Token verifiëren tegen hash in DB
        $tokenHash = hash('sha256', $token);
        $stmt = $pdo->prepare('SELECT pr.id, pr.gebruiker_id, pr.expires_at, pr.used_at, g.naam
        FROM PasswordResets pr
        JOIN Gebruikers g ON g.gebruiker_id = pr.gebruiker_id
        WHERE pr.token_hash = :hash LIMIT 1');
        $stmt->execute(['hash' => $tokenHash]);
        $row = $stmt->fetch();

        if ($row) {
            $now = new DateTime();
            $exp = new DateTime($row['expires_at']);
            if ($row['used_at'] !== null) {
                $error = 'Deze link is al gebruikt.';
            } elseif ($now > $exp) {
                $error = 'Deze link is verlopen.';
            } else {
                $valid = true;
                $uid = (int)$row['gebruiker_id'];
            }
        } else {
            $error = 'Ongeldige link.';
        }
    } catch (PDOException $e) {
        $error = 'Er ging iets mis. Probeer het later opnieuw.';
    }
} else {
    $error = 'Ontbrekende token.';
}

if ($valid && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';
    if (strlen($password) < 8) {
        $error = 'Wachtwoord moet minimaal 8 tekens zijn.';
    } elseif ($password !== $confirm) {
        $error = 'Wachtwoorden komen niet overeen.';
    } else {
        try {
            $pdo->beginTransaction();

            // Update wachtwoord
            $stmt = $pdo->prepare('UPDATE Gebruikers SET wachtwoord_hash = :hash WHERE gebruiker_id = :uid');
            $stmt->execute(['hash' => password_hash($password, PASSWORD_DEFAULT), 'uid' => $uid]);

            // Markeer token als gebruikt
            $stmt = $pdo->prepare('UPDATE PasswordResets SET used_at = NOW() WHERE token_hash = :hash');
            $stmt->execute(['hash' => hash('sha256', $token)]);

            $pdo->commit();

            $success = 'Je wachtwoord is bijgewerkt. Je kunt nu inloggen.';
            $valid = false; // verberg formulier
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $error = 'Wachtwoord resetten mislukt. Probeer opnieuw.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord resetten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>body{padding-top:20px}</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Dienst Toeslagen</a>
        </div>
    </nav>

    <div class="container" style="max-width: 520px;">
        <h1 class="h3 mt-4 mb-3">Wachtwoord resetten</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?> <a href="Login.php">Inloggen</a></div>
        <?php endif; ?>

        <?php if ($valid): ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="password" class="form-label">Nieuw wachtwoord</label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8">
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Bevestig wachtwoord</label>
                <input type="password" class="form-control" id="confirm" name="confirm" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary w-100">Bijwerken</button>
        </form>
        <?php endif; ?>
    </div>

    <footer class="bg-white border-top mt-5">
        <div class="container py-4">
            <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Dienst Toeslagen</p>
        </div>
    </footer>
</body>
</html>
