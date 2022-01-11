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
        $paedagoge = $paedagogeManager->login($_POST['email'], $_POST['password']);
        // war Login erfolgreich?
        if ($paedagoge !== false) {
            // Redirect zum Main
            header("Location: ./main.php");
        } else {
            $errors['login'] = 'Login fehlgeschlagen.';
        }
    }
}

?>

<!-- Inhalt der Seite -->
<main class="center-wrapper">
    <h1>Login</h1>
    <form action="./login.php" method="POST">
        <?php include 'inc/errormessages.inc.php'; ?>
        <div>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Passwort:</label><br>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <button name="btlogin">Login</button>
        </div>
    </form>
</main>
<?php include 'inc/footer.inc.php'; ?>



