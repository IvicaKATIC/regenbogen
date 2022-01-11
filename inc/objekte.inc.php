<?php
include '../db/connection.inc.php';
?>
<?php
// Objekt der Klasse PaedagogeManager erzeugen

    $paedagogeManager = new PaedagogeManager($connection);

// Objekt der Klasse KindManager erzeugen
$kindManager = new KindManager($connection);

// Objekt der Klasse ErziehungsberechtigteManager erzeugen
$erziehungsberechtigteManager = new ErziehungsberechtigteManager($connection);
?>
