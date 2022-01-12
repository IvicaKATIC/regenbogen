<?php
require_once ('inc/maininclude.inc.php');

$frage_id = $_POST['frage_id'];
$kompetenzerhebungs_id = $_POST['kompetenzerhebungs_id'];
$percentage = $_POST['percentage'];

$kompetenzerhebungManager->saveOrUpdateProzentsatz($frage_id, $kompetenzerhebungs_id,$percentage);

