<?php
session_start();

$_SESSION = [];
session_unset();
session_destroy();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U bent uitgelogd - Dienst toeslagen</title>

    <link rel="stylesheet" type="text/css" href="../css/logout.css">
</head>
<body>
    <div class="nav-bar-container welkom-border-bottom" id="navBarContainer">
        <div class="nav-bar" id="navBar">
            <div class="title">Dienst toeslagen</div>
        </div>
    </div>

    <div id="PageContainer">
        <div id="Content">
            <div class="left-column-new">
                <h1>U bent uitgelogd</h1>
            </div>
            <div class="left-column-new">
                <div class="simple-blok inactief">
                    <p>Bedankt voor uw bezoek.</p>
                    <p>
                        <a href="login.php">Opnieuw inloggen</a>
                    </p>
                    <br>
                    <br>
                    <p>
                        <a href="../index.php">🏚️ Home</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="FooterContainer" class="footer-container">
        <div id="Footer" class="footer"></div>
    </div>
</body>
</html>