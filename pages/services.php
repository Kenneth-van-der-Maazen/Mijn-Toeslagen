<?php
$pageTitle = "Onze Diensten";
include_once('../includes/header.php');
?>

<div class="container services-container">
    <h1 class="page-title">Onze Diensten</h1>
    
    <div class="services-intro">
        <p>Op deze pagina vindt u een overzicht van al onze diensten op het gebied van toeslagen. Wij staan voor u klaar om u te helpen bij het aanvragen, wijzigen en beheren van uw toeslagen.</p>
    </div>

    <div class="services-grid">
        <div class="service-item">
            <div class="service-icon">
                <i class="fa fa-home"></i>
            </div>
            <h2>Huurtoeslag</h2>
            <p>Hulp bij het aanvragen en berekenen van uw huurtoeslag.</p>
            <a href="huurtoeslag.php" class="btn btn-primary">Meer informatie</a>
        </div>

        <div class="service-item">
            <div class="service-icon">
                <i class="fa fa-child"></i>
            </div>
            <h2>Kinderopvangtoeslag</h2>
            <p>Ondersteuning bij het regelen van uw kinderopvangtoeslag.</p>
            <a href="kinderopvangtoeslag.php" class="btn btn-primary">Meer informatie</a>
        </div>

        <div class="service-item">
            <div class="service-icon">
                <i class="fa fa-medkit"></i>
            </div>
            <h2>Zorgtoeslag</h2>
            <p>Advies en hulp bij zorgtoeslag aanvragen en wijzigingen.</p>
            <a href="zorgtoeslag.php" class="btn btn-primary">Meer informatie</a>
        </div>

        <div class="service-item">
            <div class="service-icon">
                <i class="fa fa-graduation-cap"></i>
            </div>
            <h2>Kindgebonden Budget</h2>
            <p>Informatie en begeleiding over het kindgebonden budget.</p>
            <a href="kindgebonden-budget.php" class="btn btn-primary">Meer informatie</a>
        </div>
    </div>

    <div class="contact-section">
        <h2>Heeft u vragen over onze diensten?</h2>
        <p>Neem gerust contact met ons op voor meer informatie of een persoonlijk adviesgesprek.</p>
        <a href="contact.php" class="btn btn-secondary">Contact opnemen</a>
    </div>
</div>

<?php
include_once('../includes/footer.php');
?>