<?php
session_start();
require_once "db/connection.inc.php";
require_once "manager/paedagogemanager.inc.php";

$paedagogeManager = new PaedagogeManager($connection);

$showFormular = true; // die Registrierung soll angezeigt werden

$errors = [];

if (isset($_POST['btregister'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $admin = $_POST['admin'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben';
    }
    if (strlen($passwort) == 0) {
        $errors[] = 'Bitte ein Passwort angeben';
    }
    if ($passwort != $passwort2) {
        $errors[] = 'Die Passwörter müssen übereinstimmen';
    }


    $isadmin = false;
    if ($admin == 'isadmin'){
      $isadmin = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (count($errors) == 0) {
        if ($paedagogeManager->getPaedagogeByEmail($email) != false) {
            $errors[] = 'Pädagoge bereits registriert!';
        } else {
            $id = $paedagogeManager->registerPaedagoge($email, $passwort, $isadmin, $vorname, $nachname);
            header('Location: ./login.php');
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
        <h2>Mitarbeiter Registrierung</h2>
        <form action="." method="POST">
            <?php include 'inc/errormessages.inc.php'; ?>
            <input type="hidden" name="action" value="insert">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="passwort">Passwort:</label>
            <input type="password" id="passwort" name="passwort" required><br><br>
            <label for="passwort2">Passwort widerholen:</label>
            <input type="password" id="passwort2" name="passwort2" required><br><br>
            <label for="admin">Ist Admin</label>
            <input type="radio" id="admin" name="admin" value="isadmin"><br><br>
            <label for="admin">Ist nicht Admin</label>
            <input type="radio" id="admin" name="admin" value="isnotadmin"><br><br>
            <label for="vorname">Vorname:</label>
            <input type="text" id="vorname" name="vorname" required><br><br>
            <label for="nachname">Nachname:</label>
            <input type="text" id="nachname" name="nachname" required><br><br>
            <button name="btregister">Registrieren!</button>
        </form>
    </section>
</form>

<?php
} //Ende von if($showFormular)
include('./inc/footer.inc.php');
?>

</body>



