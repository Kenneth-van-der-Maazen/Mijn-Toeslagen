<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$pageTitle = "Over ons - Dienst Toeslagen";
include('../includes/header.php');
?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 mb-3">Over ons</h1>
                <p class="lead mb-0">Wij zijn Dienst Toeslagen, onderdeel van het ministerie van Financiën. We helpen miljoenen mensen in Nederland met toeslagen voor zorg, huur en kinderopvang, zodat iedereen kan meedoen in de maatschappij.</p>
            </div>
        </div>
    </div>
</section>

<main class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="content-card p-4 p-md-5">
                    <h2 class="h4 mb-3">Onze missie</h2>
                    <p class="mb-4">We zorgen ervoor dat toeslagen begrijpelijk, bereikbaar en betrouwbaar zijn. Op deze site vind je informatie over voorwaarden, aanvragen en wijzigingen.</p>

                    <h3 class="h5 mt-4">Wat kun je hier doen?</h3>
                    <ul class="mb-0">
                        <li>Aanvragen indienen en de status volgen</li>
                        <li>Je persoonlijke gegevens beheren</li>
                        <li>Antwoorden vinden op veelgestelde vragen</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="content-card p-4 p-md-5">
                    <h2 class="h6 text-uppercase text-muted mb-3">Snelle links</h2>
                    <div class="d-grid gap-2">
                        <a class="btn btn-outline-primary" href="services.php">Onze services</a>
                        <a class="btn btn-outline-secondary" href="contact.php">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>