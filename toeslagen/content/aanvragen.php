<?php
// 🏚️ Overzicht > Toeslagen > Aanvragen

// Alleen toegankelijk voor ingelogde gebruikers
session_start();
require_once '../../includes/user-class.php';
// require_once '../../includes/product-class.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../../user/login.php");
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
    <title>Aanvragen | Dienst Toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../../css/aanvragen.css">

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
                    <a href="../Overzicht.php">
                        <div class="menu-icon-width">
                            <img src="../../images/overzicht-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Overzicht
                    </a>
                </li>

                <li role="menuitem">
                    <a href="../PersoonlijkeGegevens.php">
                        <div class="menu-icon-width">
                            <img src="../../images/persoonlijkegegevens-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Persoonlijke gegevens
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Zorgtoeslag">
                        <div class="menu-icon-width">
                            <img src="../../images/zorgtoeslag-icon-actief.png" height="18" alt>
                        </div>
                        &nbsp; Zorgtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Huurtoeslag">
                        <div class="menu-icon-width">
                            <img src="../../images/huurtoeslag-icon-actief.png" height="18" alt>
                        </div>
                        &nbsp; Huurtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Toeslagen?toeslag=Kinderopvangtoeslag">
                        <div class="menu-icon-width">
                            <img src="../../images/kinderopvangtoeslag-menu.png" height="18" alt>
                        </div>
                        &nbsp; Kinderopvangtoeslag
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/KindgebondenBudget">
                        <div class="menu-icon-width">
                            <img src="../../images/kindgebondenbudget-menu-icon.png" height="18" alt>
                        </div>
                        &nbsp; Kindgebonden budget
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Uitbetaald">
                        <div class="menu-icon-width">
                            <img src="../../images/uitbetaald-actief.png" height="18" alt>
                        </div>
                        &nbsp; Uitbetaald
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Correspondentie">
                        <div class="menu-icon-width">
                            <img src="../../images/correspondetie-actief.png" height="18" alt>
                        </div>
                        &nbsp; Correspondentie
                    </a>
                </li>

                <li role="menuitem">
                    <a href="/Meldingen">
                        <div class="menu-icon-width">
                            <img src="../../images/meldingen-actief.png" height="18" alt>
                        </div>
                        &nbsp; Meldingen
                    </a>
                </li>

                <li role="menuitem">
                    <a href="../MijnHuishouden.php">
                        <div class="menu-icon-width">
                            <img src="../../images/mijnhuishouden-icon.png" height="18" alt>
                        </div>
                        &nbsp; Mijn huishouden
                    </a>
                </li>

            </ul>

            <!-- NAVBAR: HUIDIGE PAGINA -->
            <div class="title">Toeslag aanvragen</div>

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
        <div class="kruimelpad" id="kruimelpad">
            <div class="content">
                <a href="../Overzicht.php" class="overzicht">Overzicht</a>
                    <img src="../../images/arrow-right.png" alt>
                <a href="../toeslagen.php">Toeslagen</a>
                    <img src="../../images/arrow-right.png" alt>
                <span class="kruimelpad_huidig">Aanvragen</span>
            </div>
        </div>
    </div>

<main id="mainContentSkip" tabindex="-1">
    <article>
        <div class="container">
            <div class="row">
                <div class="offset-sm-2 col-sm-8 col-lg-7">
                    <div id="bld-main-content" class="content_main">
                        <h1>Digitaal formulier Toeslagen</h1>
                        <p class="lead">
                            Wilt u kans maken op toeslagen? Vraag hier een voorlopige aanslag aan en u ontvangt zo spoedig mogelijk bericht.
                        </p>
                        <h2>
                            Wanneer komt u niet in aanmerking voor toeslagen?
                        </h2>

                        <ul class="bld-kliklijst">
                            <li class="bld-card">
                                <button class="bld-card-header" type="button" aria-expanded="false">
                                Als u in het buitenland woont en kinderopvangtoeslag of kindgebonden budget hebt
                                <span class="arrow"></span>
                                </button>
                                <div class="bld-card-body">
                                <p>
                                    U kunt niet van toeslagen gebruik maken als u in het buitenland woont en kindgebonden budget of kinderopvangtoeslag wilt berekenen. 
                                    Dat komt doordat we geen rekening houden met de woonlandfactor en met buitenlandse toeslagen.
                                </p>
                                </div>
                            </li>

                            <li class="bld-card">
                                <button class="bld-card-header" type="button" aria-expanded="false">
                                Als u bijzonder vermogen hebt
                                <span class="arrow"></span>
                                </button>
                                <div class="bld-card-body">
                                <p>
                                    De proefberekening houdt geen rekening met speciale schadevergoedingen, smartengeld en bijzondere uitkeringen. 
                                    Hebt u bijzonder vermogen, gebruik het hulpmiddel dan niet om uw zorgtoeslag, huurtoeslag of kindgebonden budget te berekenen. 
                                    Lees meer hierover bij <a href="/vermogen/bijzonder-vermogen">Ik heb bijzonder vermogen</a>.
                                </p>
                                </div>
                            </li>

                            <li class="bld-card">
                                <button class="bld-card-header" type="button" aria-expanded="false">
                                Als u een bijzondere situatie voor de huurtoeslag hebt
                                <span class="arrow"></span>
                                </button>
                                <div class="bld-card-body">
                                <p>
                                    Gebruik de proefberekening ook niet als u huurtoeslag wilt berekenen in 1 van de volgende situaties (u kunt dan vaak meer toeslag krijgen dan het bedrag dat uit de proefberekening komt):
                                </p>
                                <ul class="bld-hyperlink">
                                    <li><a href="/huurtoeslag/langer-dan-1-jaar-buitenshuis">Iemand in uw huishouden woont langer dan 1 jaar niet thuis</a></li>
                                    <li><a href="/toeslagen/huurtoeslag/verzorging-thuis">Iemand in uw huishouden wordt thuis verzorgd</a></li>
                                    <li><a href="/toeslagen/huurtoeslag/uw-inkomen-is-niet-te-hoog-voor-de-huurtoeslag/bijzonder-inkomen-huurtoeslag">U hebt bijzonder inkomen</a><br>(inkomen naast uw gewone loon of uitkering)</li>
                                </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </article>

    <section id="bld-iah-aanvraag_toeslagen" class="bld-layer-iah" data-id="aanvraag_toeslagen">
        <div class="container">
            <div class="row">
                <div class="offset-sm-2 col-sm-8">
                    <div class="bld-form">
                        <h2 id="iah-head_pbt">Aanvragen toeslagen</h2>
                        <div class="bld-iah-main">
                            <form id="formIAH_pbt" classname="form-horizontal" action="#" method="post" onsubmit="return false">
                                <fieldset id="fsInvoer_pbt" class="clBlok">
                                    <div class="row bld-frm-question form-group lastChild firstChild" id="divV1-1_pbt">
                                        <label class="col-12 bld-form-lbl" for="V1-1_pbt">Voor welk jaar wilt u een toeslag aanvragen?</label>
                                        <div class="col-sm-6">
                                            <div class="bldc-select">
                                                <select data-sel="user-input" name="V1-1_pbt" class="form-control" id="V1-1_pbt" aria-required="true">
                                                    <option value="-1">Kies een jaar</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2021">2021</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="error_V1-1_pbt" role="alert" class="col-12 bld-error-container">
                                            <div id="message_error_V1-1_pbt" class="bldc-notification bldc-notification-warning"></div>
                                        </div>
                                    </div>
                                    <!-- Vraag 2: Voor welke toeslagen wilt u een aanvraag indienen? -->
                                    <fieldset class="row bld-frm-question form-group lastChild" id="divV1-3_pbt">
                                        <legend class="col-12 bld-form-lbl pt-0">
                                            Voor welke toeslagen wilt u een aanvraag indienen?
                                            <span class="sr-only">Vink minimaal 1 selectieveld aan</span>
                                        </legend>
                                        <div class="col-sm-8 bld-input-group">
                                            <div class="form-check">
                                                <input data-sel="user-input" class="form-check-input" type="checkbox" name="V1-3_pbt" id="V1-3_pbt_0" value="all">
                                                <label class="form-check-label" for="V1-3_pbt_0">Alle toeslagen</label>
                                            </div>
                                            <div class="form-check">
                                                <input data-sel="user-input" class="form-check-input" type="checkbox" name="V1-3_pbt" id="V1-3_pbt_1" value="v_HT_selected">
                                                <label class="form-check-label" for="V1-3_pbt_1">Huurtoeslag</label>
                                            </div>
                                            <div class="form-check">
                                                <input data-sel="user-input" class="form-check-input" type="checkbox" name="V1-3_pbt" id="V1-3_pbt_3" value="v_KOT_selected">
                                                <label class="form-check-label" for="V1-3_pbt_3">Kinderopvangtoeslag</label>
                                            </div>
                                            <div class="form-check">
                                                <input data-sel="user-input" class="form-check-input" type="checkbox" name="V1-3_pbt" id="V1-3_pbt_4" value="v_ZT_selected">
                                                <label class="form-check-label" for="V1-3_pbt_4">Zorgtoeslag</label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <!-- Header: Uw gegevens -->
                                    <!-- <div class="row">
                                        <div id="introV2-1_pbt" class="col-12">
                                            <h3>Uw gegevens</h3>
                                        </div>
                                    </div> -->

                                    <!-- Vraag 3: Hebt u een toeslagpartner? -->
                                    <fieldset class="row bld-frm-question form-group" id="divV2-1_pbt" role="radiogroup" aria-required="true">
                                        <legend class="col-12  bld-form-lbl pt-0">Hebt u een toeslagpartner?</legend>
                                        <div class="col-12">
                                            <div id="extraV2-1_pbt" class="bld-form-lbl-extra">
                                                <p>
                                                    Uw echtgenoot of geregistreerde partner is uw toeslagpartner. Woont u met iemand anders? 
                                                    <a href="/rekenhulpen/toeslagen_redir/hulpmiddel_toeslagpartner" target="_blank"> 
                                                        Kijk of u een toeslagpartner hebt 
                                                        <span class="bld-icon-tabblad"></span>
                                                    </a>.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V2-1_pbt" id="V2-1_pbt_True" value="ja" required="required">
                                                <label class="custom-control-label" for="V2-1_pbt_True"><span class="labeltext">Ja</span></label>
                                            </div>
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V2-1_pbt" id="V2-1_pbt_False" value="nee" required="required">
                                                <label class="custom-control-label" for="V2-1_pbt_False"><span class="labeltext">Nee</span></label>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Vraag 4: Wat is uw geboortedatum? -->
                                    <div class="row bld-frm-question dateDayMonthYear form-group" id="divV2-3_pbt">
                                        <fieldset class="row bldc-input-date col-12">
                                            <legend class="col-12 col-12 bld-form-lbl">Wat is uw geboortedatum?</legend>
                                            
                                            <input type="hidden" class="dateHidden" name="V2-3_pbt" id="V2-3_pbt" value="">
                                            <div class="pl-2 pr-2">
                                                <label for="V2-3_pbt-1">Dag</label>
                                                <!-- <input type="text" id="V2-3_pbt-1" maxlength="2" required pattern="\d+" /> -->
                                                <input data-sel="user-input" type="text" maxlength="2" class="form-control dateDayMonthYearInput bldc-input-date-small" autocomplete id="V2-3_pbt-1" aria-describedby="message_error_V2-3_pbt" aria-required="true">
                                            </div>
                                            <div class="pr-2">
                                                <label for="V2-3_pbt-2">Maand</label>
                                                <!-- <input type="text" id="V2-3_pbt-2" maxlength="2" required pattern="\d+" /> -->
                                                <input data-sel="user-input" type="text" maxlength="2" class="form-control dateDayMonthYearInput bldc-input-date-small" autocomplete id="V2-3_pbt-2" aria-describedby="message_error_V2-3_pbt" aria-required="true">
                                            </div>
                                            <div class="pr-2">
                                                <label for="V2-3_pbt-3">Jaar</label>
                                                <!-- <input type="text" id="V2-3_pbt-3" maxlength="4" required pattern="\d+" /> -->
                                                <input data-sel="user-input" type="text" maxlength="4" class="form-control dateDayMonthYearInput bldc-input-date-large" autocomplete id="V2-3_pbt-3" aria-describedby="message_error_V2-3_pbt" aria-required="true">
                                            </div>
                                            </input>
                                        </fieldset>
                                        <div id="error_V2-3_pbt" role="alert" class="col-12 bld-error-container">
                                            <div id="message_error_V2-3_pbt" class="bldc-notification bldc-notification-warning"></div>
                                        </div>
                                    </div>

                                    <!-- Vraag 5: In welk land woont u? -->
                                    <div class="row bld-frm-question form-group lastChild" id="divV2-11_pbt">
                                        <label class="col-12 bld-form-lbl" for="V2-11_pbt">In welk land woont u?</label>
                                        <div class="col-sm-6">
                                            <div class="bldc-select">
                                                <select data-sel="user-input" name="V2-11_pbt" class="form-control" id="V2-11_pbt" aria-describedby="message_error_V2-11_pbt" aria-required="true">
                                                    <option value="- Ander land -">- Ander land -</option>
                                                    <option value="België">België</option>
                                                    <option value="Bosnië-Herzegovina">Bosnië-Herzegovina</option>
                                                    <option value="Bulgarije">Bulgarije</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Denemarken">Denemarken</option>
                                                    <option value="Duitsland">Duitsland</option>
                                                    <option value="Estland">Estland</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="Frankrijk">Frankrijk</option>
                                                    <option value="Griekenland">Griekenland</option>
                                                    <option value="Groot-Brittannië">Groot-Brittannië</option>
                                                    <option value="Hongarije">Hongarije</option>
                                                    <option value="Ierland">Ierland</option>
                                                    <option value="IJsland">IJsland</option>
                                                    <option value="Italië">Italië</option>
                                                    <option value="Kaapverdië">Kaapverdië</option>
                                                    <option value="Kroatië">Kroatië</option>
                                                    <option value="Letland">Letland</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Litouwen">Litouwen</option>
                                                    <option value="Luxemburg">Luxemburg</option>
                                                    <option value="Macedonië">Macedonië</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marokko">Marokko</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Nederland" selected>Nederland</option>
                                                    <option value="Noorwegen">Noorwegen</option>
                                                    <option value="Oostenrijk">Oostenrijk</option>
                                                    <option value="Polen">Polen</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Roemenië ">Roemenië </option>
                                                    <option value="Servië">Servië</option>
                                                    <option value="Slovenië">Slovenië</option>
                                                    <option value="Slowakije">Slowakije</option>
                                                    <option value="Spanje">Spanje</option>
                                                    <option value="Tsjechië">Tsjechië</option>
                                                    <option value="Tunesië">Tunesië</option>
                                                    <option value="Turkije">Turkije</option>
                                                    <option value="Zweden">Zweden</option>
                                                    <option value="Zwitserland">Zwitserland</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="error_V2-11_pbt" role="alert" class="col-12 bld-error-container">
                                            <div id="message_error_V2-11_pbt" class="bldc-notification bldc-notification-warning"></div>
                                        </div>
                                    </div>

                                    <!-- Vraag 6: Wat is uw inkomn in [JAARTAL]? -->
                                    <div class="row bld-frm-question form-group" id="divV3-10_pbt">
                                        <label id="labelV3-10_pbt" class="col-12 bld-form-lbl" for="V3-10_pbt" data-avg-label="Wat is uw inkomen in {v_jaar}?">
                                            Wat is uw inkomen in ?
                                            <button type="button" href="#V3-10_pbt-help" title="Toon toelichting" class="bld-form-question-info-btn" data-toggle="collapse" data-target="#V3-10_pbt-help" aria-expanded="false" aria-controls="V3-10_pbt-help">
                                                <span class="bld-form-question-info-btn__content" tabindex="-1">
                                                    <span class="sr-only">Toon toelichting bij vraag</span>
                                                </span>
                                            </button>
                                        </label>
                                        <!-- [?] NOTIFICATIE -->
                                        <div id="V3-10_pbt-help" class="bld-notification col-12">
                                            <div class="bldc-notification bldc-notification-info collapsed" id="V3-10_pbt-help" style="">
                                                <div class="card card-body">
                                                    <div class="bldc-notification-content">
                                                        <p>
                                                            Toeslagen berekenen we met uw ‘toetsingsinkomen’. 
                                                            Dat is ongeveer uw bruto-inkomen over een heel jaar. 
                                                            En misschien moet u ook nog andere inkomsten meetellen of aftrekken. 
                                                            Daarom kunt u beter eerst de rekenhulp invullen. 
                                                            Dan weet u welk bedrag u kunt invullen.
                                                        </p>
                                                        <p>
                                                            Hebt u geen inkomen? Vul dan 0 in. 
                                                            Is uw inkomen negatief? 
                                                            Zet dan een minteken voor het bedrag.
                                                        </p>
                                                    </div>
                                                    <button type="button" class="bldc-notification-close-btn" data-sel="togglecollapse">
                                                        <span class="sr-only">Toelichting sluiten</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tekst: -->
                                        <div class="col-12">
                                            <div id="extraV3-10_pbt" class="bld-form-lbl-extra">
                                                <p>Vul uw toetsingsinkomen in. Weet u dat nog niet?<br>
                                                    <a data-id="BerekenTiLinkAanvrager" class="link-toetsingsinkomen" href="javascript:void(0)" )"="">
                                                        Ga naar de rekenhulp
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <!-- INPUT VELD INKOMEN -->
                                        <div class="bld-form-inputgrp col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                <input data-sel="user-input" type="text" name="V3-10_pbt" class="form-control" id="V3-10_pbt" aria-labelledby="input-group-prepend" aria-describedby="message_error_V3-10_pbt" aria-required="true">
                                            </div>
                                        </div>
                                        <!-- ERROR -->
                                        <div id="error_V3-10_pbt" role="alert" class="col-12 bld-error-container">
                                            <div id="message_error_V3-10_pbt" class="bldc-notification bldc-notification-warning"></div>
                                        </div>
                                    </div>

                                    <!-- Header: Medebewoners -->
                                    <!-- <div class="row">
                                        <div id="introV9-1_pbt" class="col-12">
                                            <h3>Medebewoners</h3>
                                        </div>
                                    </div> -->
                                    <!-- Vraag 7: Wonen er nog andere bewoners in uw huis? -->
                                    <fieldset class="row bld-frm-question form-group" id="divV9-1_pbt" role="radiogroup" aria-required="true">
                                        <legend class="col-12  bld-form-lbl pt-0">Wonen er nog andere mensen in uw huis?</legend>
                                        <div class="col-sm-8">
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V9-1_pbt" id="V9-1_pbt_True" value="ja" required="required">
                                                <label class="custom-control-label" for="V9-1_pbt_True">
                                                    <span class="labeltext">Ja</span>
                                                </label>
                                            </div>
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V9-1_pbt" id="V9-1_pbt_False" value="nee" required="required">
                                                <label class="custom-control-label" for="V9-1_pbt_False">
                                                    <span class="labeltext">Nee</span>
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Vraag 8: Hoeveel kale huur betaalt u per maand? -->
                                    <div class="row bld-frm-question form-group" id="divV10-10_pbt">
                                        <label class="col-12 bld-form-lbl" for="V10-10_pbt">Hoeveel kale huur betaalt u per maand?
                                            <button href="#V10-10_pbt-help" title="Toon toelichting" class="bld-form-question-info-btn collapsed" data-toggle="collapse" data-target="#V10-10_pbt-help" aria-expanded="false" aria-controls="V10-10_pbt-help">
                                                <span class="bld-form-question-info-btn__content" tabindex="-1">
                                                    <span class="sr-only">Toon toelichting bij vraag</span>
                                                </span>
                                            </button>
                                        </label>
                                        <div class="bld-notification col-12">
                                            <div class="bldc-notification bldc-notification-info collapse" id="V10-10_pbt-help"></div>
                                        </div>
                                        <div class="col-12">
                                            <div id="extraV10-10_pbt" class="bld-form-lbl-extra">
                                                <p>Woont u in een woonwagen? Lees dan eerst de toelichting.</p>
                                            </div>
                                        </div>
                                        <div class="bld-form-inputgrp col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                <input data-sel="user-input" type="text" name="V10-10_pbt" class="form-control decimalsInput" placeholder="000.00" id="V10-10_pbt" aria-labelledby="input-group-prepend" maxlength="8" aria-describedby="message_error_V10-10_pbt" aria-required="true">
                                            </div>
                                        </div>
                                        <div id="error_V10-10_pbt" role="alert" class="col-12 bld-error-container">
                                            <div id="message_error_V10-10_pbt" class="bldc-notification bldc-notification-warning"></div>
                                        </div>
                                    </div>

                                    <!-- HEADER: VERMOGEN -->
                                    <!-- <div class="row">
                                        <div id="introV11-3_pbt" class="col-12">
                                            <h3>Vermogen</h3>
                                        </div>
                                    </div> -->

                                    <!-- Vraag 9: Is uw vermogen op 1 januari [JAARTAL] meer dan €37.395? -->
                                    <fieldset class="row bld-frm-question form-group" id="divV11-3_pbt" role="radiogroup" aria-required="true">
                                        <legend class="col-12  bld-form-lbl pt-0">Is uw vermogen op 1 januari 2025 meer dan € 37.395?
                                            <button href="#V11-3_pbt-help" title="Toon toelichting" class="bld-form-question-info-btn collapsed" data-toggle="collapse" data-target="#V11-3_pbt-help" aria-expanded="false" aria-controls="V11-3_pbt-help">
                                                <span class="bld-form-question-info-btn__content" tabindex="-1">
                                                    <span class="sr-only">Toon toelichting bij vraag</span>
                                                </span>
                                            </button>
                                        </legend>
                                        <div class="bld-notification col-12">
                                            <div class="bldc-notification bldc-notification-info collapse" id="V11-3_pbt-help"></div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V11-3_pbt" id="V11-3_pbt_True" value="ja" required="required">
                                                <label class="custom-control-label" for="V11-3_pbt_True">
                                                    <span class="labeltext">Ja</span>
                                                </label>
                                            </div>
                                            <div class="form-check custom-control custom-radio custom-control-inline">
                                                <input data-sel="user-input" class="custom-control-input" type="radio" name="V11-3_pbt" id="V11-3_pbt_False" value="nee" required="required">
                                                <label class="custom-control-label" for="V11-3_pbt_False">
                                                    <span class="labeltext">Nee</span>
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>

                                </fieldset>
                                <!-- BUTTON: TOON RESULTAAT -->
                                <div class="row divButtonbar" id="divButtonsResult_pbt">
                                    <div class="col-12">
                                        <button id="butResults_pbt" type="button" class="btn btn-primary float-right" data-count=".click-open.toon-resultaat.collapse">Toon resultaten</button>
                                    </div>
                                </div>

                                <!-- EIND RESULTAAT -->
                                <div id="divResultaat_pbt">
                                    <div id="divResultTxt_pbt" class="bld-result-text">
                                        <div id="result-status_pbt" class="bld-result-status" role="status"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<footer id="footer" class="bp-footer" tabindex="-1"></footer>



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
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".bld-card-header");
  cards.forEach(btn => {
    btn.addEventListener("click", () => {
      const parent = btn.closest(".bld-card");
      const expanded = btn.getAttribute("aria-expanded") === "true";

      // Sluit alle andere cards
      document.querySelectorAll(".bld-card").forEach(c => {
        c.classList.remove("open");
        c.querySelector(".bld-card-header").setAttribute("aria-expanded", "false");
      });

      // Toggle huidige
      if (!expanded) {
        parent.classList.add("open");
        btn.setAttribute("aria-expanded", "true");
      }
    });
  });
});
</script>



<script>
document.addEventListener("DOMContentLoaded", () => {
  const jaarSelect = document.getElementById("V1-1_pbt");
  const toeslagCheckboxes = document.querySelectorAll('input[name="V1-3_pbt"]');
  const vragen = [
    "divV2-1_pbt", // Hebt u een toeslagpartner?
    "divV2-3_pbt", // Wat is uw geboortedatum?
    "divV2-11_pbt", // In welk land woont u?
    "divV3-10_pbt", // Wat is uw inkomen in ...
    "divV9-1_pbt",  // Wonen er nog andere mensen in uw huis?
    "divV10-10_pbt", // Hoeveel kale huur betaalt u?
    "divV11-3_pbt" // Is uw vermogen meer dan...
  ];

  // Verberg alle vervolg-vragen bij opstart
  vragen.forEach(id => document.getElementById(id).style.display = "none");

  // Stap 1: Jaar gekozen
  jaarSelect.addEventListener("change", () => {
    if (jaarSelect.value !== "-1") {
      document.getElementById("divV1-3_pbt").style.display = "block";
    } else {
      document.getElementById("divV1-3_pbt").style.display = "none";
      hideFollowingQuestions();
    }
  });

  // Stap 2: Toeslagen geselecteerd
  toeslagCheckboxes.forEach(chk => {
    chk.addEventListener("change", () => {
      const isChecked = Array.from(toeslagCheckboxes).some(c => c.checked);
      if (isChecked) {
        showQuestion("divV2-1_pbt");
      } else {
        hideFollowingQuestions("divV1-3_pbt");
      }
    });
  });

  // Stap 3: Toon partner-vraag → activeert rest
  document.querySelectorAll('input[name="V2-1_pbt"]').forEach(radio => {
    radio.addEventListener("change", () => {
      showQuestion("divV2-3_pbt");
    });
  });

  // Stap 4: Geboortedatum → Land
  const dateInputs = ["V2-3_pbt-1", "V2-3_pbt-2", "V2-3_pbt-3"].map(id => document.getElementById(id));
  dateInputs.forEach(inp => {
    inp.addEventListener("input", () => {
      if (dateInputs.every(x => x.value.length > 0)) showQuestion("divV2-11_pbt");
    });
  });

  // Stap 5: Land → Inkomen
  document.getElementById("V2-11_pbt").addEventListener("change", () => {
    showQuestion("divV3-10_pbt");
  });

  // Stap 6: Inkomen → Medebewoners
  document.getElementById("V3-10_pbt").addEventListener("input", e => {
    if (e.target.value.trim() !== "") showQuestion("divV9-1_pbt");
  });

  // Stap 7: Medebewoners → Huur
  document.querySelectorAll('input[name="V9-1_pbt"]').forEach(radio => {
    radio.addEventListener("change", () => showQuestion("divV10-10_pbt"));
  });

  // Stap 8: Huur → Vermogen
  document.getElementById("V10-10_pbt").addEventListener("input", e => {
    if (e.target.value.trim() !== "") showQuestion("divV11-3_pbt");
  });

  // Toon / verberg helpers
  function showQuestion(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = "block";
  }
  function hideFollowingQuestions(fromId = "") {
    let hide = false;
    vragen.forEach(id => {
      if (id === fromId) hide = true;
      if (hide) document.getElementById(id).style.display = "none";
    });
  }
});
</script>
