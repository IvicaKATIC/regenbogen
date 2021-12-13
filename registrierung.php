<?php
session_start();
require_once "db/connection.inc.php";
require_once "manager/usermanager.inc.php";


$usermanager = new UserManager($connection);


$showFormular = true; //--> soll das Registrierungsformular angezeigt werden?
$errors = [];
if (isset($_POST['btregister'])) {
    $nachname = $_POST['nachname'];
    $vorname = $_POST['vorname'];
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben';
    }
    if (strlen($passwort) == 0) {
        $errors[] = 'Bitte ein Passwort angeben';
    }
    if ($passwort != $passwort2) {
        $errors[] = 'Die Passwörter müssen übereinstimmen';
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (count($errors) == 0) {
        if ($usermanager->getUserByEmail($email) != false) {
            $errors[] = 'User bereits registriert!';
        } else {
            $id = $usermanager->registerUser($email, $passwort);
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
                <label for="Nachname">Nachname:</label>
                <input type="text" id="nachname" name="nachname" required>
                <label for="Vorname">Vorname:</label>
                <input type="text" id="vorname" name="vorname" required>
                <label for="Email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="Passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required>
                <label for="Passwort2">Passwort widerholen:</label>
                <input type="passwort2" id="passwort2" name="passwort2" required>
                <button name="btregister">Registrieren!</button>
            </form>
        </section>
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>
<?php
include('./inc/footer.inc.php');
?>

