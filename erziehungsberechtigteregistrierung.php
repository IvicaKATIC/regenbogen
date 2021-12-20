<?php
session_start();
require_once "db/connection.inc.php";
require_once "manager/erziehungsberechtigtemanager.inc.php";

$erziehungsberechtigteManager = new ErziehungsberechtigteManager($connection);

$showFormular = true; // die Registrierung soll angezeigt werden

$errors = [];

if (isset($_POST['btregister'])) {
    $email = $_POST['email'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];


    if (strlen($vorname) == 0) {
        $errors[] = 'Bitte ein Vornamen angeben!';
    }
    if (strlen($nachname) == 0) {
        $errors[] = 'Bitte ein Nachname angeben';
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (count($errors) == 0) {
        if ($erziehungsberechtigteManager->getErziehungsberechtigteByEmail($email) != false) {
            $errors[] = 'Erzeihungsberechtigte bereits registriert!';
        } else {
            $id = $erziehungsberechtigteManager->registerErziehungsberechtigte($email,$vorname, $nachname);
            header('Location: ./index.php');
            return;
        }
    }

    if (count($errors) == 0) {
        $id = 1;
        if ($erziehungsberechtigteManager->getErziehungsberechigteById($id) != false) {
            $errors[] = 'Der Erziehungsberechtigte wurde bereits registriert!';
        } else {
            $id = $erziehungsberechtigteManager->registerErziehungsberechtigte($vorname, $nachname);
            header('Location: ./index.php');
            echo "<h1>Der Erziehungsberechtigte wurde erfolgreich angelegt!!</h1>";
            return;
        }
    }

}

if ($showFormular) {
?>
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="utf-8"/>
    <title>Kompetenz Regenbogen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="js/jquery-3.6.0.js" defer></script>
    <script src="js/script.js" defer></script>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<?php include 'inc/header.inc.php'; ?>
<form action="?register=1" method="post">
    <section>
        <h2>Erziehungsberechtigte Registrierung</h2>
        <form action="." method="POST">
            <?php include 'inc/errormessages.inc.php'; ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="vorname">Vorname:</label>
            <input type="text" id="vorname" name="vorname" required><br><br>
            <label for="nachname">Nachname:</label>
            <input type="text" id="nachname" name="nachname" required><br><br>
            <button name="btregister">Erziehungsberechtigte registrieren!</button>
        </form>
    </section>
    <?php
    } //Ende von if($showFormular)
    include('./inc/footer.inc.php');
    ?>
</body>

