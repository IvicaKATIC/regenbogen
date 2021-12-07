<?php
session_start();
require_once "db/connection.ini.php";
require_once "manager/usermanager.inc.php";
//include('./inc/header.php');
//include('./inc/menu.php');

$usermanager = new UserManager($connection);


$showFormular = true; //--> soll das Registrierungsformular angezeigt werden?
$errors = [];
if(isset($_POST['btregister'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse eingeben';
    }
    if(strlen($passwort) == 0) {
        $errors[] = 'Bitte ein Passwort angeben';
    }
    if($passwort != $passwort2) {
        $errors[] =  'Die Passwörter müssen übereinstimmen';
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(count($errors) == 0) {
        if ($usermanager->getUserByEmail($email) != false){
            $errors[] = 'User bereits registriert!';
        }
        else {
            $id = $usermanager->registerUser($email,$passwort);
            header('Location: ./login.php');
            return;
        }
    }

}

if($showFormular) {
    ?>

    <form action="?register=1" method="post">
        <?php
        if (count($errors) > 0){
            echo '<div class="error">';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>';
                echo $error;
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" name="btregister" value="Abschicken">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
    </html>
<?php
include('./inc/footer.php');
?>

