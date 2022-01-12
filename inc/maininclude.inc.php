<?php
// Session starten
session_start();

// DB Connection inkludieren
require_once __DIR__ . '/../db/connection.inc.php';
// PaedagogeManager inkludieren
require_once __DIR__ . '/../manager/paedagogemanager.inc.php';

// KindManager inkludieren
require_once __DIR__ . '/../manager/kindmanager.inc.php';
// ErziehungsberechtigteManager inkludieren
require_once __DIR__ . '/../manager/erziehungsberechtigtemanager.inc.php';

require_once __DIR__ . '/../manager/kompetenzerhebungmanager.inc.php';

// Die Objekte wurden auch in die Datei objekt.inc.php inkludiert/kopiert!!!
// Objekt der Klasse PaedagogeManager erzeugen
$paedagogeManager = new PaedagogeManager($connection);

$loggedin = $paedagogeManager->isLoggedIn();

require_once ('header.inc.php');

// Objekt der Klasse KindManager erzeugen
$kindManager = new KindManager($connection);

// Objekt der Klasse ErziehungsberechtigteManager erzeugen
$erziehungsberechtigteManager = new ErziehungsberechtigteManager($connection);


$kompetenzerhebungManager = new KompetenzerhebungManager($connection);

//errormessages Array
$errors =[];
//successmessages Array
$successes =[];



