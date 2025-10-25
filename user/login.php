<?php
session_start();
require_once '../includes/user-class.php';
// require_once __DIR__ . '/../includes/db.php';

$pageTitle = "Inloggen - Dienst Toeslagen";
$error = "";

// $db  = new Database();
// $pdo = $db->getConnection();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $username = trim($_POST['username']);
//     $password = $_POST['password'];

//     $stmt = $pdo->prepare("SELECT gebruiker_id, naam, wachtwoord_hash FROM Gebruikers WHERE naam = :naam LIMIT 1");
//     $stmt->execute(['naam' => $username]);
//     $user = $stmt->fetch();

//     if ($user && password_verify($password, $user['wachtwoord_hash'])) {
        
//         $_SESSION['user_id'] = $user['gebruiker_id'];
//         $_SESSION['username'] = $user['naam'];
//         $_SESSION['logged_in'] = true;
//         header("Location: ../index.php");
//         exit;
//     } else {
//         $error = "Ongeldige inloggegevens.";
//     }
// }



try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User();

        // XSS bescherming
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        // Haalt de user account op via e-mail
        $userData = $user->getUserByEmail($email);

        // Controle loop
        if ($userData && $userData['actief'] == 1 && password_verify($password, $userData['wachtwoord_hash'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['gebruiker_id'] = $userData['gebruiker_id'];
            $_SESSION['rol_id'] = $userData['rol_id'];
            $_SESSION['email'] = $userData['email'];
            $_SESSION['naam'] = $userData['naam'];
            $_SESSION['adres'] = $userData['adres'];
            $_SESSION['woonplaats'] = $userData['woonplaats'];
            $_SESSION['geboortedatum'] = $userData['geboortedatum'];
            $_SESSION['inkomen'] = $userData['inkomen'];
            $_SESSION['gezinsgrootte'] = $userData['gezinsgrootte'];
            $_SESSION['actief'] = $userData['actief'];

            header("Location: ../toeslagen/overzicht.php");
            exit;
        } else {
            $error = "Ongeldig e-mailadres of wachtwoord.";
        }

        // echo "<br>Welkom, " . htmlspecialchars($userData['naam']) . " 👋";
        // header("refresh:2, url = ../index.php");
        // exit();
    } 
} catch (Exception $e) {
    echo "Er is een fout opgetreden: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="stylesheet" type="text/css" href="../css/login.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="../pages/toeslagen.php">Dienst Toeslagen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu uitklappen">
                <span class="navbar-toggler-icon"></span>
            </button>
            
        </div>
    </nav>

    <!-- Navbar: [Home > Toeslagen > Inloggen op Mijn toeslagen]  -->
    <nav aria-label="Breadcrumb" class="bg-light border-top py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <?php
                // Dynamisch breadcrumb trail genereren met links
                // foreach ($trail as $i => $crumb) {
                //     $isLast = $i === count($trail) - 1;
                //     $url = '#';

                //     // Automatisch URLs genereren voor bekende pagina’s
                //     if (strtolower($crumb) === 'home') {
                //         $url = '../index.php';
                //     } elseif (strtolower($crumb) === 'toeslagen') {
                //         $url = 'toeslagen.php';
                //     } elseif (strtolower($crumb) === 'aangifte') {
                //         $url = 'aangifte.php';
                //     } elseif (strtolower($crumb) === 'meer') {
                //         $url = 'meer.php';
                //     }

                //     if (!$isLast) {
                //         echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($crumb) . '</a></li>';
                //     } else {
                //         echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($crumb) . '</li>';
                //     }
                // }
                ?>
            </ol>
        </div>
    </nav>

</header>


<main id="mainContentSkip" tabindex="-1">
    <article>
        <div class="container">
            <div class="row">
                <div class="offset-sm-2 col-sm-8 col-lg-7">
                    <div id="bld-main-content" class="content_main">
                        <h1 aria-hidden="true">Inloggen op Mijn toeslagen</h1>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <p>Toeslagen is een gezamelijk project.</p>
                        <br>
                        <!-- LOGIN FROM -->
                        <form action="Login.php" method="post">
                            <!-- LOGIN: EMAIL ADRES -->
                            <div class="mb-3">
                                <input type="email" class="form-control" id="username" name="email" placeholder="E-mailadres" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Wachtwoord" required>
                            </div>
                            <button type="submit" class="bld-knop-inloggen">Inloggen in Toeslagen</button>
                        </form>

                        <br>
                        <h2>Welke periode is dit?</h2>
                        <p>
                            Dit is het beroepsproject uit periode 7. 
                            Voor deze periode moeten we een Toeslagen portaal maken. 
                            Hieraan werken Kenneth van der Maazen, Tygo Willems, Yousseff Estafanous & Jaydan Kneefel.<br>
                            Lees meer over ons via <a href="#">Contact & Informatie</a>
                        </p>

                        <h2>Hulp nodig bij inloggen?</h2>
                        <p>De manier waarop je kan gaan inloggen is doormiddel van een e-mail adres en het wachtwoord.
                            <a href="forgot_password.php">Wachtwoord vergeten?</a> Of heb je nog geen account? <a href="registration.php">Klik hier om te Registreren!</a>
                        </p>


                    </div>
                </div>
            </div>
        </div>
    </article>
</main>

<!-- <footer id="footer" class="bldc-footer" tabindex="-1">
    <div class="container">

    </div>
</footer> -->

<footer class="bg-white border-top mt-5" role="contentinfo">
	<div class="container py-4">
		<div class="row gy-3">
			<div class="col-12 col-md-6 col-lg-4">
				<h6 class="text-uppercase text-muted mb-3">Dienst Toeslagen</h6>
				<p class="mb-0 small text-muted">Informatie en ondersteuning rondom toeslagen.</p>
			</div>
			<div class="col-6 col-md-3 col-lg-2">
				<h6 class="text-uppercase text-muted mb-3">Pagina's</h6>
				<ul class="list-unstyled mb-0">
					<li><a class="link-secondary text-decoration-none" href="index.php">Home</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/about.php">About</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/services.php">Services</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/contact.php">Contact</a></li>
				</ul>
			</div>
			<div class="col-6 col-md-3 col-lg-3">
				<h6 class="text-uppercase text-muted mb-3">Juridisch</h6>
				<ul class="list-unstyled mb-0">
					<li><a class="link-secondary text-decoration-none" href="pages/privacy.php">Privacy</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/cookies.php">Cookies</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/toegankelijkheid.php">Toegankelijkheid</a></li>
					<li><a class="link-secondary text-decoration-none" href="pages/disclaimer.php">Disclaimer</a></li>
				</ul>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-between pt-4 mt-4 border-top">
			<p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Dienst Toeslagen</p>
			<a class="btn btn-sm btn-outline-secondary" href="#top" aria-label="Terug naar boven">Naar boven</a>
		</div>
	</div>
</footer>