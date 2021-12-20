<?php
require_once __DIR__ . '/../model/erziehungsberechtigte.inc.php';
class ErziehungsberechtigteManager{
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;
    function __construct(PDO $connection){
        $this->connection = $connection;
    }

    function registerErziehungsberechtigte(string $email, string $vorname, string $nachname){
        // Gibt es schon einen Erziehungsberechtigten mit dieser E-Mail Adresse?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
        $ps->bindValue('vorname', $vorname);
        $ps->bindValue('nachname', $nachname);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }


    // den Erziehungsberechtigten anhand e-mail addresse laden, sonst false
    function getErziehungsberechtigteByEmail($email) : Erziehungsberechtigte|bool {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_erziehungsberechtigte 
            WHERE Email = :email');

        $ps->bindValue('email', $email);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Erziehungsberechtigte gefunden --> zurückgeben
            return new Erziehungsberechtigte($row['ID'], $row['Email']
                , $row['Vorname'], $row['Nachname']);
        }
        // Erziehungsberechtigte nicht gefunden --> false zurückgeben
        return false;
    }

    function getErziehungsberechtigteById(int $id) :  Erziehungsberechtigte|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_erziehungsberechtigte 
            WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Erziehungsberechtigte gefunden --> zurückgeben
            return new Erziehungsberechtigte($row['vorname'], $row['nachname']);
        }
        return false;
    }

    function getCurrentErziehungsberechtigte() : bool | Erziehungsberechtigte {
        return $this->getErziehungsberechtigteById($this->getCurrentErziehungsberechtigteId());
    }

    function getCurrentErziehungsberechtigteId() : int {
        return $_SESSION['erziehungsberechtigteid'];
    }

}
