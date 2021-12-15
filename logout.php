<?php
require_once 'inc/maininclude.inc.php';

if(isset($_POST['btlogout'])){
    $paedagogeManager->logout();
    header('Location: ./');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Page Title</title>
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
    <h1>Logout</h1>
    <form action="logout.php" method="POST">
        <button name="btlogout">Abmelden</button>
    </form>
</main>
<?php
include('./inc/footer.inc.php');
?>
</body>
</html>