<?php
require_once __DIR__ . '/../model/guardian.inc.php';

class GuardianManager
{
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $email
     * @param string $firstname
     * @param string $lastname
     * @return string
     */
    function registerGuardian(string $email, string $firstname, string $lastname)
    {
        // Gibt es schon einen Erziehungsberechtigten mit dieser E-Mail Adresse?
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }
        // Erziehungsberechtigten in DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO t_erziehungsberechtigte
            (Email, Vorname, Nachname) 
            VALUES 
            (:email, :vorname, :nachname) ');
        // Named parameter werden durch Werte ersetzt
        $ps->bindValue('email', $email);
        $ps->bindValue('vorname', $firstname);
        $ps->bindValue('nachname', $lastname);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    /**
     * @param $email
     * @return Guardian|bool
     */
    // den Erziehungsberechtigten anhand E-mail Adresse laden, sonst false
    function getGuardianByEmail($email): Guardian|bool
    {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_erziehungsberechtigte 
            WHERE Email = :email');

        $ps->bindValue('email', $email);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()) {
            // Erziehungsberechtigte gefunden --> zurückgeben
            return new Guardian($row['ID'], $row['Email'], $row['Vorname'], $row['Nachname']);
        }
        // Erziehungsberechtigte nicht gefunden --> false zurückgeben
        return false;
    }

    /**
     * @param int $id
     * @return Guardian|bool
     */
    // den Erziehungsberechtigten anhand ID laden, sonst false
    function getGuardianById(int $id): Guardian|bool
    {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_erziehungsberechtigte 
            WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if ($row = $ps->fetch()) {
            // Erziehungsberechtigte gefunden --> zurückgeben
            return new Guardian($row['vorname'], $row['nachname']);
        }
        return false;
    }

    /**
     * @return bool|Guardian
     */
    function getCurrentGuardian(): bool|Guardian
    {
        return $this->getGuardianById($this->getCurrentGuardianId());
    }

    /**
     * @return int
     */
    function getCurrentGuardianId(): int
    {
        return $_SESSION['erziehungsberechtigteid'];
    }
}
