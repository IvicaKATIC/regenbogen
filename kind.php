<?php
// Start des Session mit wichtigsten Includes
require_once 'inc/maininclude.inc.php';
// DB-Connection Attribute
$host = "localhost";
$dbName = "kompetenz_regenbogen";
$dbUsername = "root";
$dbPassword = "";
$connection = $connection = new PDO("mysql:dbname=$dbName; host=$host;", $dbUsername, $dbPassword);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>


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
<?php include 'inc/header.inc.php';
require '/../db/connection.inc.php';

if (isset($_POST['aktion']) and $_POST['aktion']=='speichern') {

$vorname = "";
if (isset($_POST['vorname'])) {
$vorname = trim($_POST['vorname']);
}
$nachname = "";
if (isset($_POST['nachname'])) {
    $nachname = trim($_POST['nachname']);
}
$geschlecht = "";
if (isset($_POST['geschlecht'])) {
    $geschlecht = trim($_POST['geschlecht']);
}
$geburtsdatum = $_POST['geburtsdatum'];

$eintrittsdatum = $_POST['eintrittsdatum'];

$geschwister = $_POST['geschwister'];

$fk_erziehungsberechtigte_id = 99;

$fk_paedagogen_id = 99;

    if ( $vorname != '' or $nachname != '' or $geschlecht != '' or $geburtsdatum != '' or $eintrittsdatum != '' or $geschwister != '' )
    {
        // speichern



        $einfuegen = $connection->prepare("
                INSERT INTO t_kind (Vorname, Nachname, Geschlecht, Geburtsdatum, Eintrittsdatum, Geschwister, FK_Erziehungsberechtigte_ID, FK_Paedagogen_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
        $einfuegen->bind_param('sss', $vorname, $nachname, $geschlecht, $geburtsdatum, $eintrittsdatum, $geschwister, $fk_erziehungsberechtigte_id, $fk_paedagogen_id);
        if ($einfuegen->execute()) {
            header('Location: index.php?aktion=feedbackgespeichert');
            die();
            echo "<h1>gespeichert</h1>";
        }
    }
}
?>



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

        <input type="hidden" name="aktion" value="speichern">
        <button name="btregister">Kind anlegen!</button>
    </form>
</section>

</body>
<?php
include('./inc/footer.inc.php');
?>
</html>
