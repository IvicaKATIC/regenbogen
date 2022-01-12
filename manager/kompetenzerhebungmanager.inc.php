<?php

require_once __DIR__ . '/../model/kompetenzerhebung.inc.php';
require_once __DIR__ . '/../model/frage.inc.php';
require_once __DIR__ . '/../model/prozentsatz.inc.php';

class KompetenzerhebungManager
{
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function registerKompetenzerhebung(datetime $datum, int $fk_kind_id): bool
    {
        $ps = $this->connection->prepare('
            INSERT INTO t_kompetenzerhebung 
            (datum, fk_kind_id) 
            VALUES 
            (:datum, :fk_kind_id) ');
        $ps->bindValue('datum', $datum->format('Y.m.d'));
        $ps->bindValue('fk_kind_id', $fk_kind_id);
        $ps->execute();
        return $this->connection->lastInsertId();
    }

    function getKompetenzerhebungById(int $id): Kompetenzerhebung|bool
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
            return new Kompetenzerhebung($row['ID'], $dt, $row['FK_Kind_ID']);
        }
        return false;
    }

    function openKompetenzerhebung(int $kind_id) :  Kompetenzerhebung|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kompetenzerhebung 
            WHERE FK_Kind_ID = :id');
        // Name Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $kind_id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()){
            // ID gefunden --> zurückgeben
            return new Kompetenzerhebung($row['ID'], $row['Datum'], $row['FK_Kind_ID']);
        }
        return false;
    }

    function getFragen(int $kompetenzerhebung_id, int $bereich_id){
        $ps = $this->connection->prepare('
        SELECT * FROM t_fragen f
        LEFT JOIN t_prozentsatz p ON (f.ID = p.FK_Fragen_ID)
        WHERE f.FK_BEREICH_ID = :bereich
        AND (p.FK_Kompetenzerhebung_ID = :kompetenzerhebung OR p.FK_Kompetenzerhebung_ID is NULL)');
        $ps->bindValue('bereich', $bereich_id);
        $ps->bindValue('kompetenzerhebung', $kompetenzerhebung_id);
        $ps->execute();
        $percentages = [];
        while($row = $ps->fetch()) {
            $frage = new Frage($row['ID'],$row['Frage'],$row['FK_Bereich_ID']);
            $prozentsatz = new Prozentsatz($row['Prozentsatz']??-1,$row['FK_Kind_ID']??-1,$frage, $row['FK_Kompetenzerhebung_ID']??-1);
            $percentages[] = $prozentsatz;
        }
        return $percentages;
    }

    function saveOrUpdateProzentsatz(int $frage_id, int $kompetenzerhebungs_id, int $prozentsatz){
            $ps = $this->connection->prepare('
            SELECT *
            FROM t_prozentsatz
            WHERE FK_Kompetenzerhebung_ID = :kompetenzerhebung_id 
            AND FK_Fragen_ID = :frage_id');
            $ps->bindValue('kompetenzerhebung_id', $kompetenzerhebungs_id);
            $ps->bindValue('frage_id', $frage_id);
            $ps->execute();
            if($ps->fetch()){
               $ps = $this->connection->prepare('
               UPDATE t_prozentsatz SET Prozentsatz = :prozentsatz
                WHERE FK_Kompetenzerhebung_ID = :kompetenzerhebung_id 
            AND FK_Fragen_ID = :frage_id');
                $ps->bindValue('kompetenzerhebung_id', $kompetenzerhebungs_id);
                $ps->bindValue('frage_id', $frage_id);
                $ps->bindValue('prozentsatz', $prozentsatz);
            } else {
                $kompetenzerhebung = $this->getKompetenzerhebungById($kompetenzerhebungs_id);
                $ps = $this->connection->prepare('
                INSERT INTO t_prozentsatz (Prozentsatz, FK_Kind_ID, FK_Fragen_ID, FK_Kompetenzerhebung_ID)
                VALUES (:prozentsatz, :kind_id, :fragen_id, :kompetenzerhebung_id)
                ');
                $ps->bindValue('prozentsatz', $prozentsatz);
                $ps->bindValue('kind_id', $kompetenzerhebung->fk_kind_id);
                $ps->bindValue('fragen_id', $frage_id);
                $ps->bindValue('kompetenzerhebung_id', $kompetenzerhebungs_id);
            }
        $ps->execute();
    }

}

