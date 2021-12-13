<?php
// Session starten
session_start();

// DB Connection inkludieren
require_once __DIR__ . '/../db/connection.inc.php';
// PaedagogeManager inkludieren
require_once __DIR__ . '/../manager/paedagogemanager.inc.php';


// Objekt der Klasse UserManager erzeugen
$paedagogeManager = new PaedagogeManager($connection);
