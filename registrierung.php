<?php
session_start();
require_once "db/connection.inc.php";
require_once "manager/paedagogemanager.inc.php";


$paedagogemanager = new PaedagogeManager($connection);


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

    // todo
    //if ($admin == )

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (count($errors) == 0) {
        if ($paedagogemanager->getPaedagogeByEmail($email) != false) {
            $errors[] = 'Paedagoge bereits registriert!';
        } else {
            $id = $paedagogemanager->registerPaedagoge($email, $passwort, $admin, $vorname, $nachname);
            header('Location: ./login.php');
            return;
        }
    }

}

if ($showFormular) {
    ?>

    <form action="?register=1" method="post">

        <section>
            <h2>Registrierung</h2>
            <form action="." method="POST">
                <?php include 'inc/errormessages.inc.php'; ?>
                <input type="hidden" name="action" value="insert">
                <label for="Email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="Passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required>
                <label for="Passwort2">Passwort widerholen:</label>
                <input type="password" id="passwort2" name="passwort2" required>
                <label for="Admin">Ist Admin</label>
                <input type="radio" id="admin" name="admin" value="isadmin">
                <label for="Admin">Ist nicht Admin</label>
                <input type="radio" id="admin" name="admin" value="isnotadmin">
                <label for="Vorname">Vorname:</label>
                <input type="text" id="vorname" name="vorname" required>
                <label for="Nachname">Nachname:</label>
                <input type="text" id="nachname" name="nachname" required>
                <button name="btregister">Registrieren!</button>
            </form>
        </section>
    </form>

    <?php
} //Ende von if($showFormular)
include('./inc/footer.inc.php');
?>

</body>
</html>


