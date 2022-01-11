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

    function createKompetenzerhebung(int $id, date $datum, int $fk_kind_id): bool
    {
        $ps = $this->connection->prepare('
            INSERT INTO t_kompetenzerhebung 
            (id, datum, fk_kind_id) 
            VALUES 
            (:id, :datum, :fk_kind_id) ');
        $ps->bindValue('id', $id->id);
        $ps->bindValue('datum', $datum->format('d.m.Y'));
        $ps->bindValue('fk_kind_id', $fk_kind_id->fk_kind_id);
        return $ps->execute();
    }

    function openErhebung(int $kind_id) :  Kompetenzerhebung|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kompetenzerhebung 
            WHERE FK_Kind_ID = :id');
        // Name Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $kind_id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // ID gefunden --> zurückgeben

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
}

