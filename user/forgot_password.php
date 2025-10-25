<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/mail_config.php';

// PHPMailer via Composer autoload als beschikbaar
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

$pageTitle = "Wachtwoord vergeten - Dienst Toeslagen";

$db  = new Database();
$pdo = $db->getConnection();

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $error = 'Vul een e-mailadres in.';
    } else {
        try {
            // Zoek gebruiker op email
            $stmt = $pdo->prepare('SELECT gebruiker_id, naam FROM Gebruikers WHERE email = :email LIMIT 1');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Altijd succes teruggeven om enumeration te voorkomen
            $success = 'Als het e-mailadres bestaat, is er een herstelmail gestuurd.';

            if ($user) {
                // Token genereren
                $token = bin2hex(random_bytes(32));
                $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

                // Tabel voor tokens aanmaken
                $pdo->prepare('CREATE TABLE IF NOT EXISTS PasswordResets (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    gebruiker_id INT NOT NULL,
                    token_hash CHAR(64) NOT NULL,
                    expires_at DATETIME NOT NULL,
                    used_at DATETIME NULL,
                    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    INDEX (gebruiker_id),
                    CONSTRAINT fk_passwordresets_gebruiker FOREIGN KEY (gebruiker_id) REFERENCES Gebruikers(gebruiker_id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci')->execute();

                // Oude tokens ongeldig maken
                $pdo->prepare('UPDATE PasswordResets SET used_at = NOW() WHERE gebruiker_id = :uid AND used_at IS NULL')->execute(['uid' => $user['gebruiker_id']]);

                // Token opslaan
                $tokenHash = hash('sha256', $token);
                $stmt = $pdo->prepare('INSERT INTO PasswordResets (gebruiker_id, token_hash, expires_at) VALUES (:uid, :hash, :exp)');
                $stmt->execute(['uid' => $user['gebruiker_id'], 'hash' => $tokenHash, 'exp' => $expiresAt]);

                // Email verzenden via PHPMailer
                $resetLink = APP_BASE_URL . '/user/reset_password.php?token=' . urlencode($token);

                $mailerClass = '\\PHPMailer\\PHPMailer\\PHPMailer';
                if (class_exists($mailerClass)) {
                    $mail = new $mailerClass(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = SMTP_HOST;
                        $mail->Port = SMTP_PORT;
                        $mail->SMTPSecure = SMTP_SECURE;
                        $mail->SMTPAuth = true;
                        $mail->Username = SMTP_USER;
                        $mail->Password = SMTP_PASS;

                        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Wachtwoord herstellen - Dienst Toeslagen';
                        $mail->Body = '<h2>Wachtwoord herstellen</h2>' .
                        '<p>Beste ' . htmlspecialchars($user['naam'] ?? 'gebruiker') . ',</p>' .
                        '<p>Je hebt een verzoek gedaan om je wachtwoord te herstellen.</p>' .
                        '<p><a href="' . htmlspecialchars($resetLink) . '" style="background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:4px;">Wachtwoord resetten</a></p>' .
                        '<p>Deze link is 1 uur geldig.</p>' .
                        '<p>Als jij dit niet was, kun je deze mail negeren.</p>' .
                        '<p>Met vriendelijke groet,<br>Dienst Toeslagen</p>';

                        $mail->send();
                    } catch (Exception $e) {
                        error_log('Email error: ' . $e->getMessage());
                        // Stille fout - gebruiker ziet nog steeds succesbericht
                    }
                }
            }
        } catch (PDOException $e) {
            error_log('Forgot password error: ' . $e->getMessage());
            $success = 'Als het e-mailadres bestaat, is er een herstelmail gestuurd.';
        }
    }
}

include('../includes/header.php');
?>

<div class="container" style="max-width: 520px; margin-top: 2rem;">
    <h1 class="h3 mt-4 mb-3">Wachtwoord vergeten</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="email" class="form-label">E-mailadres</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Verstuur herstel link</button>
    </form>
    <div class="mt-3"><a href="Login.php">Terug naar inloggen</a></div>
</div>

<?php include('../includes/footer.php'); ?>
