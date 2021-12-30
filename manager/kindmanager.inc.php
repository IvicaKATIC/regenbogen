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

    function registerKind(string $vorname, string $nachname, string $geschlecht, datetime $geburtsdatum,
    datetime $eintrittsdatum, int $geschwister, int $fk_erziehungsberechtigte_id, int $fk_paedagoge_id)
    {
        // das Kind in die DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO t_kind 
            (Vorname, Nachname, Geschlecht, Geburtsdatum, Eintrittsdatum, 
             Geschwister, FK_Erziehungsberechtigte_ID, FK_Paedagoge_ID) 
            VALUES 
            (:vorname, :nachname, :geschlecht, :geburtsdatum, :eintrittsdatum, :geschwister,
             :fk_erziehungsberechtigte_id, :fk_paedagoge_id) ');
        $ps->bindValue('vorname', $vorname);
        $ps->bindValue('nachname', $nachname);
        $ps->bindValue('geschlecht', $geschlecht ? 1 : 0);
        $ps->bindValue('geburtsdatum', $geburtsdatum->format('Y.m.d'));
        $ps->bindValue('eintrittsdatum', $eintrittsdatum->format('Y.m.d'));
        $ps->bindValue('geschwister', $geschwister);
        $ps->bindValue('fk_erziehungsberechtigte_id', $fk_erziehungsberechtigte_id);
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
            return new Kind($row['ID'],$row['Vorname'], $row['Nachname'], $row['Geschlecht'],
                $row['Geburtsdatum'], $row['Eintrittsdatum'], $row['Geschwister'],
                $row['FK_Erziehungsberechtigte_ID'], $row['FK_Paedagoge_ID']);
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