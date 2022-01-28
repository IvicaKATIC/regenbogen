<?php
require_once ('inc/maininclude.inc.php');

$question_id = $_POST['question_id'];
$survey_id = $_POST['survey_id'];
$percentage = $_POST['percentage'];

$surveyManager->saveOrUpdatePercentage($question_id, $survey_id,$percentage);

