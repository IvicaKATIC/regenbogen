<?php
require_once "db/connection.ini.php";
include('./inc/header.php');
include('./inc/menu.php');
?>
<article class="center-wrapper">
<div class="content">
    <h3>Herzlich Willkommen zur Kompetenz Regenbogen.</h3>
    <p>Hier können Sie die Bewertungen <br>
        Ihre Kindergartenkinder online durchführen!</p><br><br>
    <p>Datenbank Verbindung:</p>
    <?php
    // call up db.php to establish the connection to the database
    require 'db/connection.ini.php';
    ?>
</div>
</article>

<?php
include('./inc/footer.php');
?>
