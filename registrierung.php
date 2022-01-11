<?php
require ('inc/maininclude.inc.php');

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
            header('Location: ./main.php');
            return;
        }
    }

}

if ($showFormular) {
?>

    <!-- REGISTRIERUNGS-BEREICH -->

    <section id="kontakt-bereich">
        <?php include 'inc/errormessages.inc.php'; ?>
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <header class="intro-container">
                        <h1>REGISTRIERUNG</h1>
                        <p>Bitte legen Sie hier Ihr Benutzerkonto an! Unser Service wendet sich an Leiter:innen von Kindergärten und gruppenführende Pädagog:innen.</p>
                    </header>
                </div>
            </div>
            <form id="kontakt-formular" action="?register=1" method="post">
                <div class="row">
                    <div class="col-3">
                        <label for="vorname" class="screenreader">Vorname:</label>
                        <input id="vorname" type="text" name="vorname" required placeholder="Vorname">
                    </div>
                    <div class="col-3">
                        <label for="nachname" class="screenreader">Nachname:</label>
                        <input id="nachname" type="text" name="nachname" required placeholder="Nachname">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="email" class="screenreader">E-Mail:</label>
                        <input id="email" type="email" name="email" required placeholder="Ihre E-Mail" pattern="(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|'(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*')@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" title="Gib eine gültige E-Mail Adresse ein!">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="passwort" class="screenreader">Passwort wählen:</label>
                        <input id="passwort" type="password" name="passwort" required placeholder="Passwort wählen:">
                    </div>
                    <div class="col-3">
                        <label for="passwort2" class="screenreader">Passwort wiederholen:</label>
                        <input id="passwort2" type="password" name="passwort2" required placeholder="Passwort wiederholen:">
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="admin">Nutzer:in ist Administrator</label>
                        <input type="radio" id="buttonStyle" name="admin" value="isadmin">
                    </div>
                    <div class="col-3">
                        <label for="admin"><p>Nutzer:in ist Anwender:in<p></p></label>
                        <input type="radio" id="buttonStyle" name="admin" value="isnotadmin">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button id="absendenButton" class="btn-typ-3" type="submit" name="btregister">Registrieren!</button>
                    </div>
                </div>
            </form>

        </div>

    </section>

<?php
} //Ende von if($showFormular)
include('./inc/footer.inc.php');
?>


