<?php
// Start des Session mit wichtigsten Includes
require_once 'inc/maininclude.inc.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Kompetenz Regenbogen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="js/jquery-3.6.0.js" defer></script>
    <script src="js/script.js" defer></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<!-- HEADER mit Menü -->
<?php include 'inc/header.inc.php'; ?>

<!-- Inhalt der Seite -->
<main class="center-wrapper">
    <h1>Neues Kind anlegen</h1>
    <p>Bitte Daten erfassen</p>
    <br>
    <br>
</main>
<section>
    <h2>Anlegen</h2>
    <form action="." method="POST">
        <?php include 'inc/errormessages.inc.php'; ?>
        <input type="hidden" name="action" value="insert">
        <label for="Nachname">Nachname:</label>
        <input type="text" id="nachname" name="nachname" required>
        <label for="Vorname">Vorname:</label>
        <input type="text" id="vorname" name="vorname" required>
        <label for="Geschlecht">Geschlecht:</label>
        <input type="text" id="geschlecht" name="geschlecht" required>
        <label for="Geburtsdatum">Geburtsdatum:</label>
        <input type="date" id="geburtsdatum" name="geburtsdat" required>
        <label for="Eintrittsdatum">Eintrittsdatum:</label>
        <input type="date" id="eintrittsdatum" name="eintrittsdatum" required>
        <label for="Geschwister">Anzahl der Geschwister:</label>
        <input type="integer" id="geschwister" name="geschwister" required>

        <button name="btregister">Kind anlegen!</button>
    </form>
</section>

</body>
<?php
include('./inc/footer.inc.php');
?>
</html>
