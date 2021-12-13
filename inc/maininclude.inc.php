<?php
// Session starten
session_start();

// DB Connection inkludieren
require_once __DIR__ . '/../db/connection.inc.php';
// User Manager inkludieren
require_once __DIR__ . '/../manager/paedagogemanager.inc.php';


// Objekt der Klasse UserManager erzeugen
$userManager = new UserManager($connection);
