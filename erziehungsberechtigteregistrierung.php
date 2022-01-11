<?php
require ('inc/maininclude.inc.php');

$showFormular = true; // die Registrierung soll angezeigt werden

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
        if ($email != NULL && $erziehungsberechtigteManager->getErziehungsberechtigteByEmail($email) != false) {
            $errors[] = 'Erziehungsberechtigte bereits registriert!';
        } else {
            $id = $erziehungsberechtigteManager->registerErziehungsberechtigte($email,$vorname, $nachname);
            header('Location: ./main.php');
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


<section id="kontakt-bereich">
    <?php include 'inc/errormessages.inc.php'; ?>
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

</section>

    <?php

    } //Ende von if($showFormular)
    include('./inc/footer.inc.php');
    ?>


