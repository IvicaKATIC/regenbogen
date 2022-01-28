<?php

require_once __DIR__ . '/../model/survey.inc.php';
require_once __DIR__ . '/../model/question.inc.php';
require_once __DIR__ . '/../model/percentage.inc.php';

class SurveyManager
{
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $survey_id
     * @return array
     */
    function getAveragePercentageOfArea($survey_id): array
    {
        $ps = $this->connection->prepare('
            SELECT f.FK_Bereich_ID AS area_id, AVG (p.Prozentsatz) AS average 
            FROM t_prozentsatz p
            INNER JOIN t_fragen f ON (p.FK_Fragen_ID = f.ID)
            WHERE p.FK_Kompetenzerhebung_ID = :survey_id 
            GROUP BY f.FK_Bereich_ID');
        $ps->bindValue('survey_id', $survey_id);
        $ps->execute();
        $onResult=[];
        while ($row = $ps->fetch()) {
            $area_id = $row['area_id'];
            $average = $row['average'];
            $onResult[$area_id]=$average;
        }
        return $onResult;
    }

    /**
     * @param datetime $date
     * @param int $fk_child_id
     * @return bool
     */
    function addSurvey(datetime $date, int $fk_child_id): bool
    {
        $ps = $this->connection->prepare('
            INSERT INTO t_kompetenzerhebung 
            (datum, fk_kind_id) 
            VALUES 
            (:datum, :fk_child_id) ');
        $ps->bindValue('datum', $date->format('Y.m.d'));
        $ps->bindValue('fk_child_id', $fk_child_id);
        $ps->execute();
        return $this->connection->lastInsertId();
    }

    /**
     * @return false|mixed
     */
    function getMaxID(){
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kompetenzerhebung
            order by ID desc limit 1 offset 0');
        $ps->execute();
        if ($row = $ps->fetch()) {
            return $row['ID'];
        }
        return false;
    }

    /**
     * @param int $id
     * @return Survey|bool
     */
    function getSurveyById(int $id): Survey|bool
    {
        $ps = $this->connection->prepare(' 
        SELECT * 
        FROM t_kompetenzerhebung 
        WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()) {
            // Kompetenzerhebung gefunden --> zurückgeben
            $dt = DateTime::createFromFormat('Y-m-d', $row['Datum']);
            return new Survey($row['ID'], $dt, $row['FK_Kind_ID']);
        }
        return false;
    }

    /**
     * @param int $child_id
     * @return Survey|bool
     */
    function getSurveyByChildId(int $child_id) :  Survey|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kompetenzerhebung 
            WHERE FK_Kind_ID = :id');
        // Name Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $child_id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()){
            // ID gefunden --> zurückgeben
            $dt = DateTime::createFromFormat('Y-m-d', $row['Datum']);
            return new Survey($row['ID'], $dt, $row['FK_Kind_ID']);
        }
        return false;
    }

    /**
     * @param int $survey_id
     * @param int $area_id
     * @return array
     */
    //Fragen zu bestehender Survey für den aktuellen Bereich laden und bestehende Prozentwerte mitladen
    function getQuestions(int $survey_id, int $area_id): array{
        $ps = $this->connection->prepare('
        SELECT * FROM t_fragen f
        LEFT JOIN t_prozentsatz p ON (f.ID = p.FK_Fragen_ID 
        AND ( p.FK_Kompetenzerhebung_ID = :survey OR p.FK_Kompetenzerhebung_ID IS NULL ))
        WHERE f.FK_BEREICH_ID = :area;
        ');
        $ps->bindValue('area', $area_id);
        $ps->bindValue('survey', $survey_id);
        $ps->execute();
        $percentages = [];
        while($row = $ps->fetch()) {
            $question = new Question($row['ID'],$row['Frage'],$row['FK_Bereich_ID']);
            $percentage = new Percentage($row['Prozentsatz']??-1,
            $row['FK_Kind_ID']??-1,$question, $row['FK_Kompetenzerhebung_ID']??-1);
            $percentages[] = $percentage;
        }
        return $percentages;
    }

    /**
     * @param int $question_id
     * @param int $survey_id
     * @param int $percentage
     */
    //Den Prozentsatz anhand von 3 Schlüsseln speichern bzw aktualisieren
    function saveOrUpdatePercentage(int $question_id, int $survey_id, int $percentage){
        //Prozentwert zu bestehender Erhebung und aktueller Frage laden
        $ps = $this->connection->prepare('
            SELECT *
            FROM t_prozentsatz
            WHERE FK_Kompetenzerhebung_ID = :survey_id 
            AND FK_Fragen_ID = :question_id');
        $ps->bindValue('survey_id', $survey_id);
        $ps->bindValue('question_id', $question_id);
        $ps->execute();
        //Wenn vorhanden, mit neuem Wert aktualisieren
        if($ps->fetch()){
            $ps = $this->connection->prepare('
               UPDATE t_prozentsatz SET Prozentsatz = :percentage
                WHERE FK_Kompetenzerhebung_ID = :survey_id 
            AND FK_Fragen_ID = :question_id');
            $ps->bindValue('survey_id', $survey_id);
            $ps->bindValue('question_id', $question_id);
            $ps->bindValue('percentage', $percentage);
            //Falls nicht, neuen Wert einsetzen
        } else {
            $survey = $this->getSurveyById($survey_id);
            $ps = $this->connection->prepare('
                INSERT INTO t_prozentsatz (Prozentsatz, FK_Kind_ID, FK_Fragen_ID, FK_Kompetenzerhebung_ID)
                VALUES (:percentage, :child_id, :question_id, :survey_id)
                ');
            $ps->bindValue('percentage', $percentage);
            $ps->bindValue('child_id', $survey->fk_child_id);
            $ps->bindValue('question_id', $question_id);
            $ps->bindValue('survey_id', $survey_id);
        }
        $ps->execute();
    }
}

