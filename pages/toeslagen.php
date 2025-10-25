<?php
// Start session and set login flag before any HTML output
session_start();
require '../includes/user-class.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

$breadcrumbs = [
    'index' => ['Home'],
    'toeslagen' => ['Home', 'Toeslagen'],
    'zorgtoeslag' => ['Home', 'Toeslagen', 'Zorgtoeslag'],
    'huurtoeslag' => ['Home', 'Toeslagen', 'Huurtoeslag'],
    'kindtoeslag' => ['Home', 'Toeslagen', 'Kindtoeslag']
];

$currentPage = basename($_SERVER['PHP_SELF'], ".php");
$trail = $breadcrumbs[$currentPage] ?? ['Home'];
$pageName = ucfirst($currentPage);

// if ($currentPage === "index") {
//     $pageName = "Toeslagen";
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toeslagen | Dienst Toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/toeslagen.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand" href="#">Dienst Toeslagen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu uitklappen">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<?php if ($isLoggedIn): ?>
                    	<li class="nav-item"><a class="nav-link" href="../toeslagen/overzicht.php">Mijn Overzicht</a></li>
					<?php endif; ?>

                    <!-- <li class="nav-item"><a class="nav-link" href="pages/toeslagen.php">Mijn Toeslagen</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="pages/services.php">Mijn Aanvragen</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" href="pages/contact.php">Contact</a></li> -->
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

    <!-- Navbar: [pagina > indicatie]  -->
    <nav aria-label="Breadcrumb" class="bg-light border-top py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <?php
                // Dynamisch breadcrumb trail genereren met links
                foreach ($trail as $i => $crumb) {
                    $isLast = $i === count($trail) - 1;
                    $url = '#';

                    // Automatisch URLs genereren voor bekende pagina’s
                    if (strtolower($crumb) === 'home') {
                        $url = '../index.php';
                    } elseif (strtolower($crumb) === 'toeslagen') {
                        $url = 'toeslagen.php';
                    } elseif (strtolower($crumb) === 'aangifte') {
                        $url = 'aangifte.php';
                    } elseif (strtolower($crumb) === 'meer') {
                        $url = 'meer.php';
                    }

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
                        <h3 aria-hidden="true">Toeslagen</h3>
                        <p class="lead">Een bijdrage voor de kosten van zorgverzekering, kinderen, huur en kinderopvang</p>
                    </header>
                </div>
            </div>
        </div>
    </div>

    <section class="bld-layer-featured" style="height: 302px; margin-top: -8rem;">
        <div class="container" id="read-uitgelicht">
            <div class="row">
                <!-- GEGEVENS AANPASSEN -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Bekijk uw overzicht</h3>
                        </div>
                        <div class="card-body"></div>
                        <div class="card-footer">
                            <ul class="bld-knoppenlijst">
                                <li>
                                    <?php if ($isLoggedIn): ?>
                                        <a href="../toeslagen/overzicht.php" class="bld-knop-algemeen">Ga naar dashboard</a>
                                    <?php else: ?>
                                        <a href="../user/login.php" class="bld-knop-algemeen">Log in!</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- OVERZICHT TOESLAGEN -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Beroepsproject 7</h3>
                        </div>
                        <div class="card-body">
                            <p>Lees hier alles over de laatste ontwikkelingen in dit project</p>
                        </div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="https://trello.com/b/P6mtfmCh/beroepsproject-p7" target="_blank">
                                    > Trello
                                </a>
                                <br>
                                <a href="#">
                                    > PLACEHOLDER
                                </a>
                                <br>
                                <a href="#">
                                    > PLACEHOLDER
                                </a>
                            </p>
                            

                        </div>
                    </div>
                </div>

                <!-- TOESLAG AANVRAGEN OF WIJZIGEN -->
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Hulp middellen</h3>
                        </div>
                        <div class="card-body"></div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="content/hulpmiddel-proefberekening-toeslagen.php">
                                    > Toeslagen berekenen
                                </a>
                                <br>
                                <a href="#">
                                    > Aanvragen en wijzigen
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Uw ingediende verzoeken</h3>
                        </div>
                        <div class="card-body"></div>
                        <div class="card-footer">
                            <p class="bld-hyperlink">
                                <a href="#">
                                    > Wijzigen of annuleren van een lopende aanvraag
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

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


</body>
</html>