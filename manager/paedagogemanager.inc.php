<?php
require_once __DIR__ . '/../model/paedagoge.inc';
class PaedagogeManager {
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;
    function __construct(PDO $connection){
        $this->connection = $connection;
    }

    function createPaedagoge(string $email, string $passwort, bool $admin, string $vorname, string $nachname){
        // Passwort hashen
        $passwort = password_hash($passwort, PASSWORD_DEFAULT);
        // neuangelegte paedagogen sind kein administratoren
        $admin = 0;

        // Gibt es schon einen Paedagogen mit dieser E-Mail Adresse?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }

        // User in DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO paedagoge
            (email, passwort, admin, vorname, nachname) 
            VALUES 
            (:email, :passwort, :admin, :vorname, :nachname) ');
        // Named parameter werden durch Werte ersetzt
        $ps->bindValue('email', $email);
        $ps->bindValue('passwort', $passwort);
        $ps->bindValue('admin', $admin);
        $ps->bindValue('vorname', $vorname);
        $ps->bindValue('nachname', $nachname);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    // wenn erfolgreich, Paedagogen-Objekt zurück, sonst false
    function login(string $email, string $password) : Paedagoge|bool{
        // User anhand der E-Mail Adresse laden
        $paedagoge = $this->getPaedagogeByEmail($email);
        if($paedagoge == false){
            return false;
        }

        // Passwort überprüfen
        if(!password_verify($password, $paedagoge->passwort)){
            return false;
        }

        // den Paedagogen in der session eintragen
        $_SESSION['loggedin'] = true;
        $_SESSION['paedagogeid'] = $paedagoge->id;
        $_SESSION['admin'] = $paedagoge->admin;

        return $paedagoge;
    }

    // den Paedagogen anhand e-mail addresse laden, sonst false
    function getPaedagogeByEmail($email) : Paedagoge|bool {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM paedagoge 
            WHERE email = :email');

        $ps->bindValue('email', $email);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Paedagoge gefunden --> zurückgeben
            return new Paedagoge($row['id'], $row['email'],
                $row['passwort'], $row['admin'], $row['vorname'], $row['nachname']);
        }
        // Paedagoge nicht gefunden --> false zurückgeben
        return false;
    }

    function isLoggedIn() : bool {
        if(isset($_SESSION['loggedin'])
            && $_SESSION['loggedin'] === true
            && isset($_SESSION['paedagogeid'])){
            return true;
        }
        return false;
    }

    function logout() {
        if($this->isLoggedIn()){
            $_SESSION['loggedin'] = false;
            $_SESSION['paedagogeid'] = '';
            $_SESSION['admin'] = false;
            session_destroy();
        }
    }

    function isAdmin() : bool {
        if($this->isLoggedIn()
            && isset($_SESSION['admin'])
            && $_SESSION['admin'] === true)
        {
            return true;
        }
        return false;
    }

    function getPaedagogeById(int $id) :  Paedagoge|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM paedagoge 
            WHERE id = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Paedagogen gefunden --> zurückgeben
            return new Paedagoge($row['id'], $row['email'],
                $row['passwort'], $row['admin'], $row['vorname'], $row['nachname']);
        }
        return false;
    }

    function getCurrentPaedagoge() : bool | Paedagoge {
        return $this->getPaedagogeById($this->getCurrentPaedagogeId());
    }

    function getCurrentPaedagogeId() : int {
        return $_SESSION['paedagogeid'];
    }

}

