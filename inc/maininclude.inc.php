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

// Objekt der Klasse PaedagogeManager erzeugen
$paedagogeManager = new PaedagogeManager($connection);

// Objekt der Klasse KindManager erzeugen
$kindManager = new KindManager($connection);

// Objekt der Klasse ErziehungsberechtigteManager erzeugen
$erziehungsberechtigteManager = new ErziehungsberechtigteManager($connection);

//errormessages Array
$errors =[];
