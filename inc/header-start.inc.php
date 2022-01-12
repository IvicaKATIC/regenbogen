<?php
require_once ('inc/maininclude.inc.php');

// "btregister" senden, somit auch den Formular
if (isset($_POST['btlogin'])) {
    // Eingabefelder überprüfen
    if (strlen(trim($_POST['email'])) == 0) {
        $errors['email'] = 'Email eingeben.';
    }
    if (strlen(trim($_POST['password'])) == 0) {
        $errors['password'] = 'Passwort eingeben.';
    }

    // Wenn es keine Fehler gibt → Registrierung durchführen
   /* if (count($errors) == 0) {
        // Login durchführen
        $paedagoge = $paedagogeManager->login($_POST['email'], $_POST['password']);
        // war Login erfolgreich?
        if ($paedagoge !== false) {
            // Redirect zum Main
            header("Location: ./main.php");
        } else {
            $errors['login'] = 'Login fehlgeschlagen.';
        }
    }*/
}

?>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kompetenz-Regenbogen</title>

    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="180x180" href="../images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicons/favicon-16x16.png">
    <link rel="manifest" href="../images/favicons/site.webmanifest">
    <link rel="mask-icon" href="../images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#f0f0f0">
    <meta name="msapplication-config" content="../images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/script.js"></script>
    <!-- GOOGLE-FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato|Raleway" rel="stylesheet">

    <!-- AUTOREN-STYLESHEET -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>

<!-- NAVIGATIONSLEISTE -->

<nav id="header-nav">


    <!-- DESKTOP-NAVIGATION -->

    <div class="container" id="desktop-nav">
        <div class="row">
            <div class="col-6">

                <a href="index.php" class="logo-link">
                    <img src="images/rainbow2.png" alt="Logo von Mike und Ivo">
                </a>

                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./registrierung.php">Registrieren</a></li>

                </ul>

            </div>
        </div>
    </div>
</nav>



<!-- HEADER-BANNER -->

<header id="header-banner"></header>

<!-- NEWSLETTER-BEREICH -->

<section id="newsletter-bereich">

    <div class="container">
        <div class="row">
            <div class="col-4">
                <br>
                <br>
                <p id="nb-werbetext"><span class="wichtiger-text">DER KOMPETENZ-REGENBOGEN: </span> Elementarpädagogik objektiv & transparent.</p>

            </div>
            <div class="col-2 clearfix">

                <form id="nb-form" action="./login.php" method="post">
                    <?php include 'inc/errormessages.inc.php'; ?>
                    <label class="screenreader" for="nb-email-input">E-Mail:</label>
                    <input id="nb-email-input" type="email" name="email" placeholder="Ihre E-Mail Adresse" title="Bitte eine gültige E-Mail Adresse eingeben.">

                    <label class="screenreader" for="nb-email-input">Passwort:</label>
                    <input id="nb-passwort-input" type="password" name="password" placeholder="Ihr Passwort">

                    <button class="btn-typ-1" id="nb-btn" type="submit" name="btlogin">Jetzt anmelden!</button>

                </form>

            </div>
        </div>
    </div>

</section>


<!--<li><a href="./login.php">Login</a></li>-->