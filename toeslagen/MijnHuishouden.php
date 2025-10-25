<?php
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

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn huishouden | Dienst Toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/mijnhuishouden.css">

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
                    <a href="/KindgebondenBudget">
                        <div class="menu-icon-width">
                            <img src="../images/kindgebondenbudget-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Kindgebonden budget
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Uitbetaald">
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
                    <a href="MijnHuishouden.php" class="selected" aria-current="page">
                        <div class="menu-icon-width">
                            <img src="../images/mijnhuishouden-icon.png" height="18" alt>
                        </div>
                        &nbsp; Mijn huishouden
                    </a>
                </li>

            </ul>

            <!-- NAVBAR: HUIDIGE PAGINA -->
            <div class="title">Toeslagen</div>

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

<div id="PageContainer">
    <div id="Content">
        <div class="left-column-new">
            <div class="blok-title">
                <div class="wrapper">
                    <div class="icon">
                        <img src="../images/kleinschaligwonen_klein.png" alt="">
                    </div>
                    <div class="title-left">
                        <h1>Mijn huishouden</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="left-column-new">
            <div class="simple-blok inactief">
                <h2>Mijn gegevens</h2>
                <div>
                    <div class="table-block">
                        <div class="data">
                            <dl>
                                <div class="layoutRow">
                                    <dt class="label cell1"> Naam </dt>
                                    <dd class="cell2"><?php echo strtoupper($_SESSION['naam']); ?></dd>
                                </div>
                                <div class="layoutRow">
                                    <dt class="label cell1"> ID nummer </dt>
                                    <dd class="cell2"><?php echo $_SESSION['gebruiker_id']; ?></dd>
                                </div>
                                <div class="layoutRow">
                                    <dt class="label cell1"> Rekeningnummer </dt>
                                    <dd class="cell2">NL10 BANK 0123 4556 78
                                        <span>
                                            &nbsp;
                                            <a href="/beslisboom/default.aspx?id=C1.16" aria-label="Rekeningnummer wijzigen">Wijzig</a>
                                        </span>
                                    </dd>
                                </div>
                                <div class="layoutRow">
                                    <dt class="label cell1"> Toeslagen op uw naam </dt>
                                    <dd class="cell2">Zorgtoeslag, Huurtoeslag</dd>
                                </div>
                            </dl>
                            <div class="layoutRow divider"></div>
                        </div>
                    </div>
                </div>
                <h2>Adres</h2>
                <div class="table-block">
                    <dl>
                        <div class="layoutRow">
                            <dt class="label cell1">Straat en huisnummer</dt>
                            <dd class="cell65"><?php echo $_SESSION['adres']; ?></dd>
                        </div>
                        <div class="layoutRow">
                            <dt class="label cell1">Postcode en plaats</dt>
                            <dd class="cell65"><?php echo $_SESSION['woonplaats']; ?></dd>
                        </div>
                            <div class="layoutRow divider">
                        </div>
                    </dl>
                </div>
                <h2>Burgelijke staat</h2>
                <div class="table-block">
                    <dl>
                        <div class="layoutRow">
                            <dt class="label cell1">Aantal kinderen</dt>
                            <dd class="cell65">0</dd>
                        </div>
                        <div class="layoutRow">
                            <dt class="label cell1">Overige gezinsleden</dt>
                            <dd class="cell65"><?php echo $_SESSION['gezinsgrootte']; ?></dd>
                        </div>
                            <div class="layoutRow divider">
                        </div>
                    </dl>
                </div>
                <h2>Financieel overzicht</h2>
                <div class="table-block">
                    <dl>
                        <div class="layoutRow">
                            <dt class="label cell1">Bruto maandsalaris</dt>
                            <dd class="cell65">€ 5,00</dd>
                        </div>
                        <div class="layoutRow">
                            <dt class="label cell1">Totale huishoudelijke inkomsten</dt>
                            <dd class="cell65">€ 8,30</dd>
                        </div>
                        <div class="layoutRow">
                            <dt class="label cell1">Totale waarde bezittingen</dt>
                            <dd class="cell65">€ 4,73</dd>
                        </div>
                        <div class="layoutRow">
                            <dt class="label cell1">Overig</dt>
                            <dd class="cell65">€ 1,25</dd>
                        </div>
                            <div class="layoutRow divider">
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="right-column-new">
            <div class="blok inactief">
                <div class="wrapper">
                    <img src="../images/wijzigingen-doorgeven-icon-actief.png" alt="">
                    <div class="title-left">
                        <h2>Wijziging doorgeven</h2>
                    </div>
                </div>
                <br>
                <br>
                <ul class="accordion">
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.01">
                            Ik ga trouwen of samenwonen
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.02">
                            Wij gaan uit elkaar of scheiden
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.03">
                            Er komt iemand bij mij wonen
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.04">
                            Er gaat iemand mijn huis uit
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.05">
                            Ik krijg een kind
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.06">
                            Er is iemand overleden
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.09">
                            Ik ga verhuizen
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.10">
                            Mijn huur verandert
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.16">
                            Ik heb een ander rekeningnummer
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.07">
                            Er wijzigt iets in het inkomen
                        </a>
                    </li>
                    <li class="subitem">
                        <a href="/beslisboom/default.aspx?id=C1.08">
                            Er wijzigt iets in het vermogen
                        </a>
                    </li>
                </ul>
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