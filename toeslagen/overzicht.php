<?php
// Overzicht 
//
// Controlleer database welke toeslagen toegewezen zijn aan de gebruiker!
session_start();
require_once '../includes/user-class.php';


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../user/login.php");
    exit;
}

$user_id = $_SESSION['gebruiker_id'];

$user = new User();
$gebruiker_id = $_SESSION['gebruiker_id'];
$toeslagen = $user->getUserToeslagen($gebruiker_id);

$allUsers = [];
if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] === 1) {
    $allUsers = $user->getAllUsers();
}

$toeslagStatus = [];
foreach ($toeslagen as $t) {
    $naam = strtolower(str_replace(' ', '', $t['toeslag_naam'])); // bijv. 'Zorgtoeslag' → 'zorgtoeslag'
    $toeslagStatus[$naam] = [
        'actief' => $t['actief'],
        'bedrag' => $t['bedrag'],
        'jaar'   => $t['jaar']
    ];
}



?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht - Mijn toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/overzicht.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/overzicht.css"> -->
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
                    <a href="Overzicht.php" class="selected" aria-current="page">
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
                    <a href="/Toeslagen?toeslag=Zorgtoeslag">
                        <div class="menu-icon-width">
                            <img src="../images/zorgtoeslag-icon-actief.png" height="18" alt>
                        </div>
                        &nbsp; Zorgtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Toeslagen?toeslag=Huurtoeslag">
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
                    <a href="/Toeslagen?toeslag=Kindgebondenbudget">
                        <div class="menu-icon-width">
                            <img src="../images/kindgebondenbudget-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Kindgebonden budget
                    </a>
                </li>

                <li role="menuitem">
                    <a href="Uitbetaald.php">
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
            <div class="title">Mijn Overzicht</div>

            <!-- LOGIN DROPDOWN FORM -->
            <ul id="searchAndLoginData">
                <li>
                    <div id="loginData" role="link" aria-label="Toon gebruiker en uitlog-knop">
                        <div class="name-container">
                            <span class="name"><?php echo htmlspecialchars($_SESSION['naam']); ?></span>
                        </div>
                        <div id="loginDropdown">
                            <div class="extra-login-data">
                                <p>
                                    <span class="extra-name" id="fullName"><?php echo htmlspecialchars($_SESSION['naam']); ?></span>
                                    <br>
                                    is ingelogd
                                </p>
                            </div>
                            <!-- UITLOGGEN BUTTON -->
                            <form action="../user/logout.php" id="logoutForm" method="post">
                                <input name="__RequestVerificationToken" type="hidden">
                                <a id="uitloggenClick" tabindex="0">Uitloggen</a>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- WELKOMST BERICHT -->
    <div class="welkom">
        <div class="h1-container">
            <div class="donerpaars">
                <h1>Welkom <span class="welkom"><?php echo htmlspecialchars($_SESSION['naam']); ?></span></h1>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div id="PageContainer">
        <div id="Content">
            <div class="left-column-new">
                <ul>
                    <!-- PERSOONLIJKE GEGEVENS -->
                    <li>
                        <div class="blok inactief row">
                            <div class="col single">
                                <div class="col verticalMiddle">
                                    <div class="icon">
                                        <img src="../images/persoonlijkegegevens-menu-icon.png" class="img-document" alt>
                                    </div>
                                    <div class="link-to-page-panel">
                                        <h2 id="PGTitel" class="title-left mr-20">Persoonlijke gegevens</h2>
                                        <div class="verbergresponsive-small">
                                            <a id="Persoonlijke Gegevens" href="persoonlijkegegevens.php" aria-descrubedby="PGTitel">Bekijken</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="link-to-page-panel toonresponsive">
                                    <a id="Persoonlijke Gegevens" href="/PersoonlijkeGegevens" aria-descrubedby="PGTitel">Bekijken</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- ZORGTOESLAG -->
                    <li>
                        <?php if (!empty($toeslagStatus['zorgtoeslag']) && $toeslagStatus['zorgtoeslag']['actief']): ?>
                            <div class="blok actief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/zorgtoeslag-icon-actief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="ZorgtoeslagTitle">Zorgtoeslag</h2>
                                            <a href="/Zorgtoeslag" aria-describedby="ZorgtoeslagTitle">
                                                Uw toeslag voor <?= htmlspecialchars($toeslagStatus['zorgtoeslag']['jaar']) ?> is 
                                                € <?= number_format($toeslagStatus['zorgtoeslag']['bedrag'], 2, ',', '.') ?>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="info-panel row">
                                        <div class="col left">
                                            <p>&emsp; Toeslag is actief ingesteld!</p>
                                        </div>
                                        <div class="col right">
                                            <a href="zorgtoeslag.php">Bekijken</a>
                                        </div>
                                    </div>
                                    <!-- LET OP! MOET NOG AANGEPAST WORDEN! -->
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2025" aria-describedby="HuurtoeslagTitle">2025</a>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2024" aria-describedby="HuurtoeslagTitle">2024</a>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2023" aria-describedby="HuurtoeslagTitle">2023</a>
                                    <a class="button-white button-extra" href="/Toeslagen/huurtoeslag" aria-describedby="HuurtoeslagTitle">Andere jaren</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="blok inactief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/zorgtoeslag-icon-inactief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="ZorgtoeslagTitle">Zorgtoeslag</h2>
                                            <a href="content/toeslag-aanvragen.php" aria-describedby="ZorgtoeslagTitle">Aanvragen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>

                    <!-- HUURTOESLAG -->
                    <li>
                        <?php if (!empty($toeslagStatus['huurtoeslag']) && $toeslagStatus['huurtoeslag']['actief']): ?>
                            <div class="blok actief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/huurtoeslag-icon-actief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="HuurtoeslagTitle">Huurtoeslag</h2>
                                            <a href="/Huurtoeslag" aria-describedby="HuurtoeslagTitle">
                                                Uw toeslag voor <?= htmlspecialchars($toeslagStatus['huurtoeslag']['jaar']) ?> is 
                                                € <?= number_format($toeslagStatus['huurtoeslag']['bedrag'], 2, ',', '.') ?>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="info-panel row">
                                        <div class="col left">
                                            <p>&emsp; Toeslag is actief ingesteld!</p>
                                        </div>
                                        <div class="col right">
                                            <a href="/Specificatie?toeslag=huurtoeslag&actualyear=2024&id=776851571">Bekijken</a>
                                        </div>
                                    </div>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2025" aria-describedby="HuurtoeslagTitle">2025</a>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2024" aria-describedby="HuurtoeslagTitle">2024</a>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2023" aria-describedby="HuurtoeslagTitle">2023</a>
                                    <a class="button-white button-extra" href="/Toeslagen/huurtoeslag" aria-describedby="HuurtoeslagTitle">Andere jaren</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="blok inactief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/huurtoeslag-icon-inactief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="HuurtoeslagTitle">Huurtoeslag</h2>
                                            <a href="content/aanvragen.php" aria-describedby="HuurtoeslagTitle">Aanvragen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>

                    <!-- KINDGEBONDEN BUDGET -->
                    <li>
                        <?php if (!empty($toeslagStatus['kindgebondenbudget']) && $toeslagStatus['kindgebondenbudget']['actief']): ?>
                            <div class="blok actief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/kindgebondenbudget-menu-icon.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="KindgebondenTitle">Kindgebonden budget</h2>
                                            <a href="/KindgebondenBudget" aria-describedby="KindgebondenTitle">
                                                Uw toeslag voor <?= htmlspecialchars($toeslagStatus['kindgebondenbudget']['jaar']) ?> is 
                                                € <?= number_format($toeslagStatus['kindgebondenbudget']['bedrag'], 2, ',', '.') ?>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="info-panel row">
                                        <div class="col left">
                                            <p>&emsp; Toeslag is actief ingesteld!</p>
                                        </div>
                                        <div class="col right">
                                            <a href="/Specificatie?toeslag=huurtoeslag&actualyear=2024&id=776851571">Bekijken</a>
                                        </div>
                                    </div>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2025" aria-describedby="HuurtoeslagTitle">2025</a>
                                    <a class="button-white button-extra" href="/Toeslagen/huurtoeslag" aria-describedby="HuurtoeslagTitle">Andere jaren</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="blok inactief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/kindgebondenbudget-icon.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="KindgebondenTitle">Kindgebonden budget</h2>
                                            <a href="/KindgebondenBudget" aria-describedby="KindgebondenTitle">Aanvragen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>

                    <!-- KINDEROPVANG TOESLAG -->
                    <li>
                        <?php if (!empty($toeslagStatus['kinderopvangtoeslag']) && $toeslagStatus['kinderopvangtoeslag']['actief']): ?>
                            <div class="blok actief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/kinderopvangtoeslag-icon-actief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="KinderopvangTitle">Kinderopvang toeslag</h2>
                                            <a href="/KinderopvangToeslag" aria-describedby="KinderopvangTitle">
                                                Uw toeslag voor <?= htmlspecialchars($toeslagStatus['kinderopvangtoeslag']['jaar']) ?> is 
                                                € <?= number_format($toeslagStatus['kinderopvangtoeslag']['bedrag'], 2, ',', '.') ?>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="info-panel row">
                                        <div class="col left">
                                            <p>&emsp; Toeslag is actief ingesteld!</p>
                                        </div>
                                        <div class="col right">
                                            <a href="/Specificatie?toeslag=kinderopvangoeslag&actualyear=2024&id=776851571">Bekijken</a>
                                        </div>
                                    </div>
                                    <a class="button-white button-extra" href="/Specificatie?toelsag=huurtoeslag&actualyear=2025" aria-describedby="HuurtoeslagTitle">2025</a>
                                    <a class="button-white button-extra" href="/Toeslagen/huurtoeslag" aria-describedby="HuurtoeslagTitle">Andere jaren</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="blok inactief row">
                                <div class="col single">
                                    <div>
                                        <div class="icon">
                                            <img src="../images/kinderopvangtoeslag-icon-inactief.png" alt>
                                        </div>
                                        <div class="toeslag-content">
                                            <h2 id="KindgebondenTitle">Kinderopvang toeslag</h2>
                                            <a href="/KindgebondenBudget" aria-describedby="KindgebondenTitle">Aanvragen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>

                    
                </ul>

                <!-- GEBRUIKERSLIJST (verborgen standaard) -->
                <div class="blok actief row" id="userListBlock" style="display:none;">
                    <div class="col single">
                        <div class="toeslag-content">
                            <h2 id="UserListTitle">Alle Gebruikers</h2>
                            <pre>
                            <?php print_r($allUsers); ?>
                            </pre>
                            <ul id="userListContent">
                                <?php if (!empty($allUsers)): ?>
                                    <?php foreach ($allUsers as $u): ?>
                                        <li>
                                            <strong><?= htmlspecialchars($u['naam']); ?></strong>
                                            (<?= htmlspecialchars($u['email']); ?>) -
                                            Rol: <?= htmlspecialchars($u['rol_id']); ?> -
                                            <?= $u['actief'] ? 'Actief' : 'Inactief'; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>Geen gebruikers gevonden.</li>
                                <?php endif; ?>
                            </ul>
                            <br>
                            <button id="closeUserList" class="button-white">Sluiten</button>
                        </div>
                    </div>
                </div>

            </div>

            

            <!-- MENU RECHTERZIJDE -->
            <div class="right-column-new">
                <div class="blok inactief">
                    <div class="wrapper">
                        <img src="../images/wijzigingen-doorgeven-icon-actief.png" alt>
                        <div class="title-left">
                            <h2>Wijziging doorgeven</h2>
                        </div>
                    </div>
                    <br>
                    <ul class="accordion">
                        <!-- <li><a href="#">Gezin en huishouden</a></li> -->
                        <li><a href="#">Inkomens & vermogen</a></li>
                        <li><a href="#">Wonen</a></li>
                        <li><a href="#">Kinderen</a></li>
                        <li><a href="#">Administratie</a></li>
                        <li><a href="#">Toeslag stoppen</a></li>
                    </ul>
                </div>

                <!-- UITBETAALD -->
                <div class="blok inactief verbergresponsive">
                    <div class="wrapper">
                        <img src="../images/uitbetaald-actief.png" alt>
                        <div class="title-left">
                            <h2>Uitbetaald</h2>
                        </div>
                    </div>
                    <br>
                    <div class="content">
                        De toeslagen voor november zijn uitbetaald.
                        <br>
                        <a href="/Uitbetaald">Bekijken</a>
                    </div>
                </div>

                <!-- CORRESPONDENTIE -->
                <div class="blok inactief verbergresponsive">
                    <div class="wrapper">
                        <img src="../images/correspondetie-actief.png" alt>
                        <div class="title-left">
                            <h2>Correspondentie</h2>
                        </div>
                    </div>
                    <br>
                    <div class="content">
                        <a href="/Correspondentie">Bekijken</a>
                    </div>
                </div>

                <!-- MELDINGEN -->
                <div class="blok inactief verbergresponsive">
                    <div class="wrapper">
                        <img src="../images/meldingen-actief.png" alt>
                        <div class="title-left">
                            <h2>Meldingen</h2>
                        </div>
                    </div>
                    <br>
                    <div class="content">
                        De actuele situatie op [DATUM],<br> 
                        [TIJD]
                        <a href="/Mijnhuishouden">Bekijken</a>
                    </div>
                </div>

                <!-- MIJN HUISHOUDEN -->
                <div class="blok inactief verbergresponsive">
                    <div class="wrapper">
                        <img src="../images/mijnhuishouden-icon.png" alt>
                        <div class="title-left">
                            <h2>Mijn huishouden</h2>
                        </div>
                    </div>
                    <br>
                    <div class="content">
                        Geschat inkomen voor 2026: € 12.000
                        <br>
                        <a href="/Statusoverzicht">Bekijken</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

<div id="FooterContainer" class="footer-container">
    <div id="Footer" class="footer">
        <div class="flex-container">
            <div class="col">
                <h2 class="heading" aria-label="Navigeer naar links over Contact, help en Cookies">Over project</h2>
                <ul>
                    <li class="intern" alt>
                        <a href="/Contact" target="_self" rel="noopener noreferrer">Contact</a>
                    </li>
                    <li class="intern" alt>
                        <a href="/Help" target="_self" rel="noopener noreferrer">Help</a>
                    </li>
                    <li class="intern" alt>
                        <a href="/Cookies" target="_self" rel="noopener noreferrer">Cookies</a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <h2 class="heading" aria-label="Ga direct naar links over Toegankelijkheid, Privacy en uw Persoonsgegevens">Direct naar</h2>
                <a href="toeslagen.php">Index pagina</a>
                <br>
                <a href="overzicht.php">Mijn overzicht</a>
                <!-- LINKEDIN LINKS -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ======== MENU & LOGIN TOGGLE (bestond al, laten staan) ========

    // ======== GEBRUIKERSLIJST ADMIN FUNCTIE ========
    const showUserListBtn = document.getElementById('showUserList');
    const closeUserListBtn = document.getElementById('closeUserList');
    const userListBlock = document.getElementById('userListBlock');
    const allToeslagItems = document.querySelectorAll('.left-column-new ul > li');

    if (showUserListBtn && userListBlock) {
        showUserListBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Verberg alle andere blokken
            allToeslagItems.forEach(item => item.style.display = 'none');
            // Toon de gebruikerslijst
            userListBlock.style.display = 'block';
        });
    }

    if (closeUserListBtn) {
        closeUserListBtn.addEventListener('click', function() {
            // Sluit de gebruikerslijst
            userListBlock.style.display = 'none';
            // Toon weer alle originele <li> items
            allToeslagItems.forEach(item => item.style.display = 'block');
        });
    }
});
</script>

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




</body>
</html>