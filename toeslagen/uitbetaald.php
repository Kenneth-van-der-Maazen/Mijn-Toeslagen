<?php
// [2023] [2024] [2025]

// Alleen toegankelijk voor ingelogde gebruikers
session_start();
require_once '../includes/user-class.php';
// require_once '../../includes/product-class.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$userObj = new User();
$gebruiker = $userObj->getUserById($_SESSION['gebruiker_id']);


$jaar = isset($_GET['ActualYear']) ? intval($_GET['ActualYear']) : date('Y');
$uitbetalingen = $userObj->getUserPayments($_SESSION['gebruiker_id'], $jaar);

$toeslagen = [];
foreach ($uitbetalingen as $betaling) {
    $toeslag = $betaling['toeslag_naam'] ?? 'Onbekend';
    $toeslagen[$toeslag][] = $betaling;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitbetaalde toeslagen 2025</title>

    <!-- <link rel="stylesheet" type="text/css" href="../css/CSSDefault.css"> -->
    <link rel="stylesheet" type="text/css" href="../css/uitbetaald.css">
    <!-- <link rel="stylesheet" type="text/css" href="../../css/aanvragen.css"> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>
    <!-- NAVIGATIE -->
    <div class="nav-bar-container" id="navBarContainer">
        <div class="nav-bar" id="navBar">
            <a id="menuToggle" tabindex="0" role="link" aria-label="Menu " aria-controls="menu" class="">
                <div class="menu-toggle-icon-wrapper">
                    <div class="menu-toggle-icon"></div>
                </div>
                <div class="menu-toggle-title" id="menuToggleTitle">Menu</div>
            </a>

            <ul id="menu" role="menu" class="">
                <li role="menuitem">
                    <a href="Overzicht.php">
                        <div class="menu-icon-width">
                            <img src="../images/overzicht-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Overzicht
                    </a>
                </li>

                <li role="menuitem">
                    <a href="PersoonlijkeGegevens.php">
                        <div class="menu-icon-width">
                            <img src="../images/persoonlijkegegevens-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Persoonlijke gegevens
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Zorgtoeslag">
                        <div class="menu-icon-width">
                            <img src="../images/zorgtoeslag-icon-actief.png" height="18" alt>
                        </div>
                        &nbsp; Zorgtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Huurtoeslag">
                        <div class="menu-icon-width">
                            <img src="../images/huurtoeslag-icon-actief.png" height="18" alt>
                        </div>
                        &nbsp; Huurtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Toeslagen?toeslag=Kinderopvangtoeslag">
                        <div class="menu-icon-width">
                            <img src="../images/kinderopvangtoeslag-menu.png" height="18" alt>
                        </div>
                        &nbsp; Kinderopvangtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/KindgebondenBudget">
                        <div class="menu-icon-width">
                            <img src="../images/kindgebondenbudget-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Kindgebonden budget
                    </a>
                </li>

                <li role="menuitem">
                    <a href="Uitbetaald.php" class="selected" aria-current="page">
                        <div class="menu-icon-width">
                            <img src="../images/uitbetaald-actief.png" height="18" alt>
                        </div>
                        &nbsp; Uitbetaald
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Correspondentie">
                        <div class="menu-icon-width">
                            <img src="../images/correspondetie-actief.png" height="18" alt>
                        </div>
                        &nbsp; Correspondentie
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Meldingen">
                        <div class="menu-icon-width">
                            <img src="../images/meldingen-actief.png" height="18" alt>
                        </div>
                        &nbsp; Meldingen
                    </a>
                </li>

                <li role="menuitem">
                    <a href="MijnHuishouden.php">
                        <div class="menu-icon-width">
                            <img src="../images/mijnhuishouden-icon.png" height="18" alt>
                        </div>
                        &nbsp; Mijn huishouden
                    </a>
                </li>

            </ul>

            <!-- NAVBAR: HUIDIGE PAGINA -->
            <div class="title">Uitbetalingen</div>

            <!--  -->
            <ul id="searchAndLoginData">
                <li>
                    <div id="loginData" role="link" aria-label="Toon gebruiker en uitlog-knop">
                        <div class="name-container">
                            <span class="name"><?php echo htmlspecialchars($_SESSION['naam']); ?></span>
                        </div>
                        <div id="loginDropdown" class>
                            <div class="extra-login-data">
                                <p>
                                    <span class="extra-name" id="fullName"><?php echo htmlspecialchars($_SESSION['naam']); ?></span>
                                    <br>
                                    is ingelogd
                                </p>
                            </div>
                            <!-- UITLOGGEN BUTTON -->
                            <form action="../../user/logout.php" id="logoutForm" method="post">
                                <input name="__RequestVerificationToken" type="hidden">
                                <a id="uitloggenClick" tabindex="0">Uitloggen</a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- NAVBAR SUB [Overzicht > Persoonlijke gegevens] -->
        <!-- <div class="kruimelpad" id="kruimelpad">
            <div class="content">
                <a href="../Overzicht.php" class="overzicht">Overzicht</a>
                    <img src="../../images/arrow-right.png" alt>
                <a href="../toeslagen.php">Toeslagen</a>
                    <img src="../../images/arrow-right.png" alt>
                <span class="kruimelpad_huidig">Aanvragen</span>
            </div>
        </div> -->

        <div id="meerjarenMenu" class>
            <div>
                <ul id="jaren" style="min-width: 162px;">
                    <li>
                        <a href="/Uitbetaald?ActualYear=2023">2023</a>
                    </li>
                    <li>
                        <a href="/Uitbetaald?ActualYear=2024">2024</a>
                    </li>
                    <li>
                        <a id="meerjarenSelected" href="/Uitbetaald?ActualYear=2025">2025</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<div id="PageContainer">
    <div id="Content">
        <div class="left-column-new">
            <div class="blok-title">
                <div class="wrapper">
                    <div class="icon">
                        <img src="../images/eurobiljetten_klein.png" alt="">
                    </div>
                    <div class="title-left"><h1>Uitbetaalde toeslagen 2025</h1></div>
                </div>
            </div>
        </div>
        <div class="left-column-new">
            <div class="simple-blok inactief">
                <p>
                    Hieronder ziet u per toeslag een overzicht van de bedragen die wij over 2025 hebben uitbetaald.
                    <br><br>
                    Het uitbetaalde bedrag kan afwijken van het maandbedrag dat in de voorschotbeschikking staat. 
                    Wij verrekenen uw toeslag namelijk met toeslagen die u eerder te veel of te weinig hebt gekregen. 
                    Ook kan het uitbetaalde bedrag per maand € 1 hoger zijn. 
                    Dit heeft te maken met de afronding van de bedragen.
                </p>
                <div>
                    <h2>Let op!</h2>
                    <p>
                        De overzichten zijn alleen zichtbaar voor de persoon op wiens naam de toeslag staat.
                    </p>
                </div>
                <p></p>

                <!-- EEN FOREACH LOOP MAKEN MET UITBETALINGS DATA UIT DATABASE -->
                <?php foreach ($toeslagen as $naam => $betalingen): ?>
                <div class="form-block">
                    <h2><?php echo htmlspecialchars($naam) . ' ' . htmlspecialchars($jaar); ?></h2>
                    <div class="table-block">
                        <table class="special-data" aria-label="uitbetalingen">
                            <thead>
                                <tr>
                                    <th class="emphasis-2">Datum</th>
                                    <th class="emphasis-2">Uitbetaald</th>
                                    <th class="emphasis-2">Rekening</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($betalingen as $betaling): ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($betaling['date'])); ?></td>
                                        <td>€ <?php echo number_format($betaling['bedrag'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($betaling['rekening']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
        <div class="right-column-new">
            <div class="blok inactief">
                <img src="../images/vraagteken.png" alt="">
                <div class="content">
                    <h2>Toeslag terugbetalen?</h2>
                    <p>Kijk hoe u dat doet.</p>
                    <a class="extern" id="Overzicht betalen en ontvangen" href="#" target="_blank" rel="noopener noreferrer">Log in op het overzicht betalen en ontvangen</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="FooterContainer" class="footer-container">
    <div id="Footer" class="footer">
        <div class="flex-container">
            <div class="col">
                <h2 class="heading" aria-label="Navigeer naar links over Contact, Help en Cookies">Over Mijn toeslagen</h2>
                <ul>
                    <li class="intern" alt=""><a href="/Contact" target="_self" rel="noopener noreferrer">Contact</a></li>
                    <li class="intern" alt=""><a href="/Help" target="_self" rel="noopener noreferrer">Help</a></li>
                    <li class="intern" alt=""><a href="/Cookies" target="_self" rel="noopener noreferrer">Cookies</a></li>
                </ul>
            </div>
            <div class="col">
                <h2 class="heading" aria-label="Ga direct naar links over Toegankelijkheid, Privacy en uw Persoonsgegevens en Copyright">Direct naar</h2>
                <ul>
                    <li class="extern" alt="Opent een nieuw venster"><a href="https://www.belastingdienst.nl/portal_toeslagen/link_169.html" target="_blank" rel="noopener noreferrer">Toegankelijkheid</a></li>
                    <li class="extern" alt="Opent een nieuw venster"><a href="https://www.belastingdienst.nl/portal_toeslagen/link_170.html" target="_blank" rel="noopener noreferrer">Privacy en uw persoonsgegevens</a></li>
                    <li class="extern" alt="Opent een nieuw venster"><a href="https://www.belastingdienst.nl/portal_toeslagen/link_171.html" target="_blank" rel="noopener noreferrer">Copyright</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ======== HOOFDMENU TOGGLE ========
    const toggle = document.getElementById('menuToggle');
    const menu = document.getElementById('menu');
    const icon = document.querySelector('.menu-toggle-icon');
    const title = document.getElementById('menuToggleTitle');

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('show');
        icon.classList.toggle('open');
        title.textContent = menu.classList.contains('show') ? 'Sluiten' : 'Menu';
    });

    document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('show');
            icon.classList.remove('open');
            title.textContent = 'Menu';
        }
    });

    // ======== LOGIN DROPDOWN TOGGLE ========
    const loginData = document.getElementById('loginData');
    const loginDropdown = document.getElementById('loginDropdown');

    loginData.addEventListener('click', function (e) {
        // voorkom dat klik op 'Uitloggen' ook dropdown opent/sluit
        if (e.target.id === 'uitloggenClick') return;
        e.stopPropagation();
        loginDropdown.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
        if (!loginData.contains(e.target)) {
            loginDropdown.classList.remove('show');
        }
    });

    // ======== UITLOGGEN FUNCTIONALITEIT ========
    const logoutLink = document.getElementById('uitloggenClick');
    const logoutForm = document.getElementById('logoutForm');

    if (logoutLink && logoutForm) {
        logoutLink.addEventListener('click', function (e) {
            e.preventDefault(); // voorkom standaard klik-actie
            logoutForm.submit(); // verstuur het formulier naar logout.php
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.uitbetaling-header').forEach(header => {
        header.addEventListener('click', () => {
            header.classList.toggle('open');
            const body = header.nextElementSibling;
            body.classList.toggle('show');
        });
    });
});
</script>
