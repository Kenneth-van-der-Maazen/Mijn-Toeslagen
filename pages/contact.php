<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$pageTitle = "Contact - Dienst Toeslagen";
include('../includes/header.php');
?>

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 mb-3">Contact</h1>
                <p class="lead mb-0">Wilt u contact opnemen met Dienst Toeslagen? Hieronder zetten we een aantal contactgegevens op een rij.</p>
            </div>
        </div>
    </div>
</section>

<main id="main-content" class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="content-card p-4 p-md-5">
                    <h2 class="h4 mb-4">Contact</h2>
                    <p class="mb-4">Wilt u contact opnemen met Dienst Toeslagen? Hieronder zetten we een aantal contactgegevens op een rij.</p>

                    <h3 class="h5 mt-3">Vragen over toeslagen</h3>
                    <p>Op Toeslagen.nl kunt u toeslagen aanvragen, wijzigingen doorgeven en antwoord vinden op uw vragen over toeslagen. Daar leest u ook hoe u via de BelastingTelefoon, social media en toeslagenservicepunten in contact kunt komen met onze medewerkers.</p>

                    <h3 class="h5 mt-4">Woordvoerders en persvoorlichters</h3>
                    <p>De contactgegevens van de woordvoerders en persvoorlichter van Dienst Toeslagen vindt u op Rijksoverheid.nl. Deze medewerkers zijn alleen bereikbaar voor de media.</p>

                    <h3 class="h5 mt-4">Contact voor intermediairs</h3>
                    <p>Voor intermediairs als gemeenten en maatschappelijk dienstverleners, is Team Relatiebeheer van Dienst Toeslagen het eerste aanspreekpunt. Heeft u als intermediair een vraag aan Dienst Toeslagen? Kijk dan eerst of uw vraag wordt beantwoord op de website van Kennisnetwerk. Als dit niet het geval is, kunt u uw vraag stellen aan Team Relatiebeheer.</p>

                    <h3 class="h5 mt-4">Werken bij Dienst Toeslagen</h3>
                    <p>Dienst Toeslagen is aan het groeien. Meewerken aan het betaalbaar maken van vitale voorzieningen? Ontdek de mogelijkheden, bekijk de vacatures.</p>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="content-card p-4 p-md-5">
                    <h2 class="h6 text-uppercase text-muted mb-3">Zie ook</h2>
                    <ul class="mb-0">
                        <li>Woo-verzoek aan Dienst Toeslagen</li>
                        <li>Onderwerp</li>
                        <li>Kwetsbaarheid melden</li>
                        <li>Service</li>
                        <li>Contact</li>
                        <li>Sitemap</li>
                        <li>Archief</li>
                        <li>Over deze site</li>
                        <li>Copyright</li>
                        <li>Privacy</li>
                        <li>Cookies</li>
                        <li>Toegankelijkheid</li>
                        <li>Kwetsbaarheid melden</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>