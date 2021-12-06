<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Kompetenz_Regenbogen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="js/jquery-3.6.0.js" defer></script>
    <script src="js/script.js" defer></script>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<!-- HEADER mit Menü -->
<header class="center-wrapper">
    <div class="title">Kompetenz_Regenbogen</div>
    <div class="menu">
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./login.html">Login</a></li>
        </ul>
    </div>
</header>

<!-- Inhalt der Seite -->
<main class="center-wrapper">
    <h1>"Kompetenz Regenbogen" - ihre persönliche online Auswertung!</h1>
    <p>Inhalt</p>

    <?php
    // call up db.php to establish the connection to the database
    require 'inc/dbconnection.php';
    ?>
</main>

</body>
</html>
