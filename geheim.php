<html>
<head>
    <title>Login</title>
</head>
<body>
<?php
include "#zugang.php" ;
$username = $_POST['username'];
$passwort = $_POST['passwort'];
$okusername = "Username";
$okpasswort = "Passwort";
if ($username == $okusername && $passwort == $okpasswort) {
    include "#auswertung.php" ;
} else {
    echo "Falsche Eingabe" ;
}
?>
</body>
</html>

