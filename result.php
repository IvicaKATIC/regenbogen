
<?php
require_once ('db/connection.inc.php');
require('manager/surveyManager.inc.php');
require('manager/childManager.inc.php');
require('diag.php');

$child_id = $_GET['child_id'];
$survey_id = $_GET['survey'];
$title = 'Auswertung Kompetenzerhebung';

//KindManager erstellen um Vorname und Nachname zu holen
$childManager = new ChildManager($connection);
$child = $childManager->getChildById($child_id);
$firstname = $child->firstname;
$lastname = $child->lastname;
$date = date('d.m.Y');


//Kompetenzmanager erstellen um Durchschnittswerte der gegenständlichen Erhebung auslesen zu können
$surveyManager = new SurveyManager($connection);
$averages = $surveyManager->getAveragePercentageOfArea($survey_id);

//Nachkommastellen entfernen
$area1Percentage = intval($averages[1]);
$area2Percentage = intval($averages[2]);
$area3Percentage = intval($averages[3]);
$area4Percentage = intval($averages[4]);
$area5Percentage = intval($averages[5]);
$area6Percentage = intval($averages[6]);
$totalPercentage = number_format((($area1Percentage+$area2Percentage+$area3Percentage+$area4Percentage+$area5Percentage+$area6Percentage)/6),0);

//Arrays füllen
$scale = array('SKALIERT' => 100);
$total = array('GESAMT  '=> $totalPercentage);
$data = array('  BEREICH 1' => $area1Percentage, 'BEREICH 2' => $area2Percentage,
                'BEREICH 3' => $area3Percentage, 'BEREICH 4' => $area4Percentage,
                'BEREICH 5' => $area5Percentage, 'BEREICH 6' => $area6Percentage,
                'GESAMT' => $totalPercentage);

//Objekt der PDF Diagrammklasse erstellen
$pdf = new PDF_Diag();
//Ausrichtung Querformat
$pdf->AddPage('l');
//Balkendiagramm
$pdf->SetFont('Arial', 'BIU', 16);
$pdf->Cell(0, 5, $title . ' ' . $firstname .' '. $lastname, 0, 1);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 5, 'Datum der Auswertung: ' . $date, 0, 1);
$pdf->Ln(20);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
//Skala erzeugen
$pdf->BarDiagram(265, 0, $scale,  '  %l :%v%', array(0,0,0));
$pdf->Ln(2);
//Balken pro Bereich erzeugen
$pdf->BarDiagramNoScales(265, 120, $data, '%l: %v%', NULL);
//Ausgabe PDF
$pdf->Output();
?>
