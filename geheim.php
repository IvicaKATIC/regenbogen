<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="db/login.php">Einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;


