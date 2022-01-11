
<?php

session_start();

$_SESSION= ARRAY();

SESSION_DESTROY();

HEADER('location: index.php');
?>



<?php
//require_once 'inc/maininclude.inc.php';
//
//if(isset($_POST['btlogout'])){
//    $paedagogeManager->logout();
//    header('Location: ./');
//}
//?>
<!---->
<!--<!-- Inhalt der Seite -->-->
<!--    <main class="center-wrapper">-->
<!--        <!-- LEISTUNGEN-BEREICH -->-->
<!---->
<!--        <section id="leistungen-bereich">-->
<!--    <h1>Logout</h1>-->
<!--    <form action="logout.php" method="POST">-->
<!--        <button name="btlogout">Abmelden</button>-->
<!--    </form>-->
<!--        </section>-->
<!--</main>-->
<!---->
<?php
//include('./inc/footer.inc.php');
//?>