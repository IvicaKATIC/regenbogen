<?php
require_once __DIR__ . '/../model/child.inc.php';

class ChildManager
{
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    // das Kind in die Datenbank einfügen

    /**
     * @param string $firstname
     * @param string $lastname
     * @param int $gender
     * @param datetime $dob
     * @param datetime $boarding
     * @param int $siblings
     * @param int $fk_guardian_id
     * @param int $fk_educator_id
     * @return string
     */
    function registerChild(string   $firstname, string $lastname, int $gender, datetime $dob,
                           datetime $boarding, int $siblings, int $fk_guardian_id, int $fk_educator_id)
    {
        // das Kind in die DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO t_kind 
            (Vorname, Nachname, Geschlecht, Geburtsdatum, Eintrittsdatum, 
             Geschwister, FK_Erziehungsberechtigte_ID, FK_Paedagoge_ID) 
            VALUES  
            (:vorname, :nachname, :geschlecht, :geburtsdatum, :eintrittsdatum, :geschwister,
             :fk_erziehungsberechtigte_id, :fk_paedagoge_id) ');
        $ps->bindValue('vorname', $firstname);
        $ps->bindValue('nachname', $lastname);
        $ps->bindValue('geschlecht', $gender);
        $ps->bindValue('geburtsdatum', $dob->format('Y.m.d'));
        $ps->bindValue('eintrittsdatum', $boarding->format('Y.m.d'));
        $ps->bindValue('geschwister', $siblings);
        $ps->bindValue('fk_erziehungsberechtigte_id', $fk_guardian_id);
        $ps->bindValue('fk_paedagoge_id', $fk_educator_id);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    /**
     * @param int $id
     * @return Child|bool
     */
    function getChildById(int $id): Child|bool
    {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_kind 
            WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()) {
            // Kind gefunden --> zurückgeben
            $dtdob = DateTime::createFromFormat('Y-m-d', $row['Geburtsdatum']);
            $dtboarding = DateTime::createFromFormat('Y-m-d', $row['Eintrittsdatum']);
            return new Child($row['ID'], $row['Vorname'], $row['Nachname'], $row['Geschlecht'],
                $dtdob, $dtboarding, $row['Geschwister'],
                $row['FK_Erziehungsberechtigte_ID'], $row['FK_Paedagoge_ID']);
        }
        return false;
    }

    /**
     * @return bool|Child
     */
    function getCurrentChild(): bool|Child
    {
        return $this->getChildById($this->getCurrentKindId());
    }

    /**
     * @return int
     */
    function getCurrentKindId(): int
    {
        return $_SESSION['kindid'];
    }

}