<?php
// 🏚️ Overzicht > Persoonlijke gegevens

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
    <title>Persoonlijke gegevens | Dienst Toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/persoonlijkegegevens.css">
    <link rel="stylesheet" type="text/css" href="../css/aanvragen.css">

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
                    <a href="PersoonlijkeGegevens.php" class="selected" aria-current="page">
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
            <div class="title">Mijn gegevens</div>

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

        <!-- NAVBAR SUB [Overzicht > Persoonlijke gegevens] -->
        <div class="kruimelpad" id="kruimelpad">
            <div class="content">
                <a href="Overzicht.php" class="overzicht">Overzicht</a>
                    <img src="../images/arrow-right.png" alt>
                <span class="kruimelpad_huidig">Persoonlijke gegevens</span>
            </div>
        </div>
    </div>

<!-- MAIN CONTENT HIERONDER -->
<div id="PageContainer">
    <div id="Content" class="paddingkruimelpad">
        <div class="left-column-new">
            <div class="blok-title">
                <div class="wrapper">
                    <div class="icon">
                        <img src="../images/persoonlijke-gegevens-icon_32x50.png" alt="">
                    </div>
                    <div class="title-left">
                        <h1>Persoonlijke gegevens</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="left-column-new">
            <div class="blok inactief">
                <div class="data">
                    <div class="flex">
                        <div class="placeholderHelp"></div>
                        <h2>Mijn gegevens</h2>
                    </div>
                    <form action="/PersoonlijkeGegevens/MijnGegevensOpslaan" class="mvc-form" id="MijnGegevensOpslaan" method="post">
                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Naam</label>
                            <?php echo strtoupper($_SESSION['naam']); ?>
                            <!-- <div>K D VAN DER MAAZEN</div> -->
                        </div>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Email</label>
                            <?php echo $_SESSION['email']; ?>
                            <span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/beslisboom/default.aspx?id=C1.16" aria-label="Email adres wijzigen">Wijzig</a>
                            </span>
                        </div>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp">
                                <div class="toeslagen-help-modal" aria-label="helpvenster" role="dialog">
                                    <div class="toeslagen-modal-content" tabindex="0">
                                        <a class="close-toeslagen-modal" tabindex="0" aria-label="helpvenster sluiten">×</a>
                                        <div>
                                            We gebruiken uw telefoonnummer alleen als het over uw toeslagen gaat. 
                                            Bijvoorbeeld als we vragen hebben, of als we u iets belangrijks willen vertellen. 
                                            <br><br> 
                                            Een Nederlands telefoonnummer bestaat uit 10 cijfers. 
                                            Gebruik geen spaties. Een buitenlands telefoonnummer mag beginnen met 00 of met een +.
                                        </div>
                                    </div>
                                </div>

                                <!-- Help knop met vraagteken -->
                                <a class="toeslagen-modal-link-new" href="#" aria-haspopup="dialog" aria-label="helpvenster openen">help</a>
                            </div>

                            <label>Telefoonnummer</label>
                            <input type="text" id="burgerTelefoonnummerOpgevoerd" name="Burger.TelefoonnummerOpgevoerd" autofocus="autofocus">
                            <input type="hidden" id="burgerTelefonischContactgegevenId" name="Burger.TelefonischContactgegevenId">
                        </div>
                        

                        <br>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Straat en huisnummer</label>
                            <?php echo $_SESSION['adres']; ?>
                            <span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/beslisboom/default.aspx?id=C1.16" aria-label="Adres wijzigen">Wijzig</a>
                            </span>
                        </div>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Woonplaats</label>
                            <?php echo $_SESSION['woonplaats']; ?>
                            <span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/beslisboom/default.aspx?id=C1.16" aria-label="Woonplaats wijzigen">Wijzig</a>
                            </span>
                        </div>

                        <br>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Geboortedatum</label>
                            <?php echo $_SESSION['geboortedatum']; ?>
                        </div>

                        <div class="layoutRow contactgegevens">
                            <div class="placeholderHelp"></div>
                            <label>Betalingsrekening</label>
                            <?php// echo $_SESSION['email']; ?>
                            <span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/beslisboom/default.aspx?id=C1.16" aria-label="Rekeningnummer wijzigen">Wijzig</a>
                            </span>
                        </div>

                        <div class="button-row">
                            <button class="alignRight" type="submit">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="blok inactief">
                <div class="data">
                    <form action="/PersoonlijkeGegevens/Contactpersoonwijzigen" class="mvc-form" id="PersoonGegevens" method="post">
                        <div class="flex contactgegevens">
                            <div class="placeholderHelp"> 
                                <div class="toeslagen-help-modal" aria-label="helpvenster" role="dialog">
                                    <div class="toeslagen-modal-content" tabindex="-1">
                                        <a class="close-toeslagen-modal" tabindex="-1" aria-label="helpvenster sluiten">×</a>
                                        <div>Wilt u liever niet dat wij contact met u opnemen, maar met iemand anders? Dan kunt u ervoor kiezen om een contactpersoon op te geven.</div>
                                    </div>
                                </div>
                                    <a class="toeslagen-modal-link-new" href="#" aria-haspopup="dialog" aria-label="helpvenster openen">help</a>
                                </div>
                                    <h2>Mijn contactpersoon</h2>
                                    <input class="edit-pencil" type="image" src="../images/edit-icon_16x16.png" alt="Wijzigen">
                                </div>
                                <div class="layoutRow contactgegevens">
                                    <div class="placeholderHelp"></div>
                                    <label>Naam</label>
                                </div>
                                <div class="layoutRow contactgegevens">
                                    <div class="placeholderHelp"></div>
                                    <label>Telefoon</label>
                                </div>
                                <div class="layoutRow contactgegevens">
                                    <div class="placeholderHelp"></div>
                                    <label>Plaats</label>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="right-column-new"></div>
    </div>
</div>






<div id="FooterContainer" class="footer-container">
    <div id="Footer" class="footer">
        <div class="flex-container">
            <div class="col">
                <h2 class="heading" aria-label="Navigeer naar links over Contact, help en Cookies">Over Mijn toeslagen</h2>
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
                <!-- LINKEDIN LINKS -->
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
document.addEventListener("DOMContentLoaded", function() {
    const helpButton = document.querySelector(".toeslagen-modal-link-new");
    const modal = document.querySelector(".toeslagen-help-modal");
    const closeBtn = document.querySelector(".close-toeslagen-modal");

    // Open modal
    helpButton.addEventListener("click", function(e) {
        e.preventDefault();
        modal.classList.add("active");
        // Focus op de modal voor toegankelijkheid
        modal.querySelector(".toeslagen-modal-content").focus();
    });

    // Sluit modal met de sluitknop
    closeBtn.addEventListener("click", function() {
        modal.classList.remove("active");
        helpButton.focus(); // focus terug op help-knop
    });

    // Sluit modal als buiten de content geklikt wordt
    modal.addEventListener("click", function(e) {
        if (e.target === modal) {
            modal.classList.remove("active");
        }
    });

    // Sluit modal met Escape-toets
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && modal.classList.contains("active")) {
            modal.classList.remove("active");
            helpButton.focus();
        }
    });
});
</script>
