<?php
// Start session en check loginstatus
session_start();
require '../includes/user-class.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Breadcrumbs
$breadcrumbs = [
    'index' => ['Home'],
    'toeslagen' => ['Home', 'Toeslagen'],
    'zorgtoeslag' => ['Home', 'Toeslagen', 'Zorgtoeslag'],
];

$currentPage = basename($_SERVER['PHP_SELF'], ".php");
$trail = $breadcrumbs[$currentPage] ?? ['Home'];
$pageName = ucfirst($currentPage);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zorgtoeslag | Dienst Toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/zorgtoeslag.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
    <!-- Navigatie -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Dienst Toeslagen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu uitklappen">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link" href="../user/dashboard.php">Mijn Gegevens</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link active" href="toeslagen.php">Mijn Toeslagen</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Mijn Aanvragen</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item"><a class="btn btn-outline-danger" href="../user/Logout.php">Uitloggen</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="btn btn-primary" href="../user/login.php">Inloggen</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb navigatie -->
    <nav aria-label="Breadcrumb" class="bg-light border-top py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <?php
                foreach ($trail as $i => $crumb) {
                    $isLast = $i === count($trail) - 1;
                    $url = '#';

                    if (strtolower($crumb) === 'home') $url = '../index.php';
                    elseif (strtolower($crumb) === 'toeslagen') $url = 'toeslagen.php';
                    elseif (strtolower($crumb) === 'zorgtoeslag') $url = 'zorgtoeslag.php';

                    if (!$isLast) {
                        echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($crumb) . '</a></li>';
                    } else {
                        echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($crumb) . '</li>';
                    }
                }
                ?>
            </ol>
        </div>
    </nav>
</header>

<!-- ======== MAIN CONTENT ======== -->
<main id="mainContent">
    <div class="bld-layer-title-v3">
        <div class="d-flex flex-wrap">
            <div class="col-sm-6 bld-layer-title-v3-bg"></div>
            <div class="col-sm-6 bld-layer-title-v3-bg toeslagen bld-bg-image-center" id="toeslagen"></div>
        </div>
        <div class="container bld-layer-title-v3-content">
            <div class="row">
                <div class="col-sm-6">
                    <header>
                        <h1 aria-hidden="true">Zorgtoeslag</h1>
                        <p class="lead">Een bijdrage voor de kosten van uw zorgverzekering</p>
                    </header>
                </div>
            </div>
        </div>
    </div>

    <section class="bld-layer-featured" style="height: 302px; margin-top: -8rem;">
        <div class="container" id="read-uitgelicht">
            <div class="row">
                <!-- ZORGTOESLAG -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Uw zorgtoeslag</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                Bekijk hier ...
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="zorgtoeslag.php">
                                    > Maak eens schatting van uw toetsinkomen
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- GEGEVENS AANPASSEN -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Zorgtoeslag aanvragen of wijzigen?</h3>
                        </div>
                        <div class="card-body"></div>
                        <div class="card-footer">
                            <ul class="bld-knoppenlijst">
                                <li>
                                    <?php if ($isLoggedIn): ?>
                                        <a href="../user/dashboard.php" class="bld-knop-algemeen">Mijn zorgtoeslag</a>
                                    <?php else: ?>
                                        <a href="../user/dashboard.php" class="bld-knop-algemeen">Log in op Mijn zorgtoeslag</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- ZORGTOESLAG -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Mijn inkomen verandert</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                Maak een schatting en geef uw nieuwe inkomen door.
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="zorgtoeslag.php">
                                    > Maak eens schatting van uw toetsinkomen
                                </a>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="bld-date">
                                <span class="bld-date-text">
                                    <h3>Uitbetalen zorgtoeslag</h3>
                                </span>
                                <span class="bld-date-tile">
                                    <span class="bld-date-day">20</span>
                                    <span class="bld-date-month">okt</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>
                                Maandag 20 oktober voor 24.00 uur krijgt u uw toeslag van de maand november.
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="#">
                                    Alle betaaldatums
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- ======== FOOTER ======== -->
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
					<li><a class="link-secondary text-decoration-none" href="../index.php">Home</a></li>
					<li><a class="link-secondary text-decoration-none" href="toeslagen.php">Toeslagen</a></li>
					<li><a class="link-secondary text-decoration-none" href="services.php">Aanvragen</a></li>
					<li><a class="link-secondary text-decoration-none" href="contact.php">Contact</a></li>
				</ul>
			</div>
			<div class="col-6 col-md-3 col-lg-3">
				<h6 class="text-uppercase text-muted mb-3">Juridisch</h6>
				<ul class="list-unstyled mb-0">
					<li><a class="link-secondary text-decoration-none" href="privacy.php">Privacy</a></li>
					<li><a class="link-secondary text-decoration-none" href="cookies.php">Cookies</a></li>
					<li><a class="link-secondary text-decoration-none" href="toegankelijkheid.php">Toegankelijkheid</a></li>
					<li><a class="link-secondary text-decoration-none" href="disclaimer.php">Disclaimer</a></li>
				</ul>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-between pt-4 mt-4 border-top">
			<p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Dienst Toeslagen</p>
			<a class="btn btn-sm btn-outline-secondary" href="#top" aria-label="Terug naar boven">Naar boven</a>
		</div>
	</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
