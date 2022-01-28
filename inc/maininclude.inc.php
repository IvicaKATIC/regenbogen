<?php
// Session starten
session_start();

// DB Connection inkludieren
require_once __DIR__ . '/../db/connection.inc.php';
// PaedagogeManager inkludieren
require_once __DIR__ . '/../manager/educatorManager.inc.php';
// KindManager inkludieren
require_once __DIR__ . '/../manager/childManager.inc.php';
// ErziehungsberechtigteManager inkludieren
require_once __DIR__ . '/../manager/guardianManager.inc.php';
// KompetenzerhebungsManager inkludieren
require_once __DIR__ . '/../manager/surveyManager.inc.php';


// Objekt der Klasse PaedagogeManager erzeugen
$educatorManager = new EducatorManager($connection);
//Aufruf der Methode, die den Login-Status feststellt
$loggedin = $educatorManager->isLoggedIn();
//Jetzt kann der Header inkludiert werden -> Unterscheidung Header of eingeloggt oder nicht
require_once('header.inc.php');

// Objekt der Klasse KindManager erzeugen
$childManager = new ChildManager($connection);

// Objekt der Klasse ErziehungsberechtigteManager erzeugen
$guardianManager = new GuardianManager($connection);

// Objekt der Klasse KompetenzerhebungsManager erzeugen
$surveyManager = new SurveyManager($connection);

//errormessages Array
$errors = [];
//successmessages Array
$successes = [];
