<?php
require_once __DIR__ . '/../model/kind.inc.php';
class KindManager
{
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function registerKind(int $id, string $vorname, string $nachname, string $geschlecht, datetime $geburtsdatum,
    datetime $eintrittsdatum, int $geschwister, int $fk_erziehungsberechtigter_id, int $fk_paedagoge_id)
    {
        // das Kind in die DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO t_kind 
            (ID, Vorname, Nachname, Geschlecht, Geburtsdatum, Eintrittsdatum, 
             Geschwister, FK_Erziehungsberechtigter_ID, FK_Paedagoge_ID) 
            VALUES 
            (:id, :vorname, :nachname, :geschlecht, :geburtsdatum, :eintrittsdatum, :geschwister,
             :fk_erziehungsberechtigter_id, :fk_paedagoge_id) ');
        $ps->bindValue('id', $id);
        $ps->bindValue('vorname', $vorname);
        $ps->bindValue('nachname', $nachname);
        $ps->bindValue('geschlecht', $geschlecht);
        $ps->bindValue('geburtsdatum', $geburtsdatum->format('d.m.Y'));
        $ps->bindValue('eintrittsdatum', $eintrittsdatum->format('d.m.Y'));
        $ps->bindValue('geschwister', $geschwister);
        $ps->bindValue('fk_erziehungsberechtigter_id', $fk_erziehungsberechtigter_id);
        $ps->bindValue('fk_paedagoge_id', $fk_paedagoge_id);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    function getKindById(int $id) :  Kind|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kind 
            WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Kind gefunden --> zurückgeben
            return new Kind($row['id'], $row['vorname'], $row['nachname'], $row['geschlecht'],
                $row['geburtsdatum'], $row['eintrittsdatum'], $row['geschwister'],
                $row['fk_erziehungsberechtigter_id'], $row['fk_paedagoge_id']);
        }
        return false;
    }

    function getCurrentKind() : bool | Kind {
        return $this->getKindById($this->getCurrentKindId());
    }

    function getCurrentKindId() : int {
        return $_SESSION['kindid'];
    }

}