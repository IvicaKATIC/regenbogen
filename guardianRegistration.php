<?php
require ('inc/maininclude.inc.php');

$showFormular = true; // die Registrierung soll angezeigt werden

if (isset($_POST['btregister'])) {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];


    if (strlen($firstname) == 0) {
        $errors[] = 'Bitte einen Vornamen angeben!';
    }
    if (strlen($lastname) == 0) {
        $errors[] = 'Bitte einen Nachname angeben';
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (count($errors) == 0) {
        if ($email != NULL && $guardianManager->getGuardianByEmail($email) != false) {
            $errors[] = 'Erziehungsberechtigte bereits registriert!';
        } else {
            $id = $guardianManager->registerGuardian($email, $firstname, $lastname);
            header('Location: ./guardianRegistration.php?success=guardianregistered');
            return;
        }
    }
    if (count($errors) == 0) {
        $id = 1;
        if ($guardianManager->getGuardianById($id) != false) {
            $errors[] = 'Der Erziehungsberechtigte wurde bereits registriert!';
        } else {
            $id = $guardianManager->registerGuardian($firstname, $lastname);
            header('Location: ./guardianRegistration.php?success=guardianregistered');
            return;
        }
    }
}

if ($showFormular) {
?>

<section id="kontakt-bereich">
    <?php include 'inc/errormessages.inc.php'; ?>
    <?php include 'inc/successmessages.inc.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <header class="intro-container">
                    <h1>REGISTRIERUNG DER ERZIEHUNGSBERECHTIGTEN</h1>
                    <p>Bitte legen Sie hier zunächst die Kontaktdaten des Elternteils bzw. des Erziehungsberechtigten eines Kindes an!</p>
                </header>
            </div>
        </div>
        <form id="kontakt-formular" action="?register=1" method="post">
            <div class="row">
                <div class="col-3">
                    <label for="firstname" class="screenreader">Vorname:</label>
                    <input id="firstname" type="text" name="firstname" required placeholder="Vorname">
                </div>
                <div class="col-3">
                    <label for="lastname" class="screenreader">Nachname:</label>
                    <input id="lastname" type="text" name="lastname" required placeholder="Nachname">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="email" class="screenreader">E-Mail:</label>
                    <input id="email" type="email" name="email" placeholder="E-Mail Adresse eingeben" pattern="(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|'(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*')@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])" title="Gib eine gültige E-Mail Adresse ein!">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <button id="absendenButton" class="btn-typ-3" type="submit" name="btregister">Registrieren!</button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <br>
</section>

    <?php

    } //Ende von if($showFormular)
    include('./inc/footer.inc.php');
    ?>


