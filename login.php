<?php
include ('inc/maininclude.inc.php');

// "btregister" senden, somit auch den Formular
if (isset($_POST['btlogin'])) {
    // Eingabefelder überprüfen
    if (strlen(trim($_POST['email'])) == 0) {
        $errors['email'] = 'Email eingeben.';
    }
    if (strlen(trim($_POST['password'])) == 0) {
        $errors['password'] = 'Passwort eingeben.';
    }

    // Wenn es keine Fehler gibt → Registrierung durchführen
    if (count($errors) == 0) {
        // Login durchführen
        $paedagoge = $educatorManager->login($_POST['email'], $_POST['password']);
        // war Login erfolgreich?
        if ($paedagoge !== false) {
            // Redirect zum Main
            header("Location: ./index.php");
        } else {
            $errors['login'] = 'Login fehlgeschlagen.';
        }
    }
}

?>

<!-- Inhalt der Seite -->
<main class="center-wrapper">
    <section id="über-uns-bereich">
    <h1><?php include 'inc/errormessages.inc.php'; ?></h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

    </section>
</main>
<?php include 'inc/footer.inc.php'; ?>



