<?php

require_once 'inc/maininclude.inc.php';

// "btregister" senden, somit auch den Formular
if(isset($_POST['btlogin'])){
    // Eingabefelder überprüfen
    if(strlen(trim($_POST['email'])) == 0){
        $errors['email'] = 'Email eingeben.';
    }
    if(strlen(trim($_POST['password'])) == 0){
        $errors['password'] = 'Passwort eingeben.';
    }

    // Wenn es keine Fehler gibt --> Registrierung durchführen
    if(count($errors) == 0){
        // Login durchführen
        $user = $userManager->login($_POST['email'], $_POST['password']);
        // war Login erfolgreich?
        if($user !== false){
            // Redirect zum Index
            header("Location: ./?loggedin=true");
        } else {
            $errors['login'] = 'Login fehlgeschlagen.';
        }
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Kompetenz Regenbogen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="js/jquery-3.6.0.js" defer></script>
    <script src="js/script.js" defer></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<!-- HEADER mit Menü -->
<?php include 'inc/header.inc.php'; ?>

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

</body>
</html>

