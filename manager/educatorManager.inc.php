<?php
require_once __DIR__ . '/../model/educator.inc.php';
class EducatorManager {
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $admin
     * @param string $firstname
     * @param string $lastname
     * @return string
     */
    function registerEducator(string $email, string $password, bool $admin, string $firstname, string $lastname){
        // Passwort hashen
        $password = password_hash($password, PASSWORD_DEFAULT);


        // Gibt es schon einen Paedagogen mit dieser E-Mail Adresse?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }

        // User in DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO t_paedagoge
            (Email, Passwort, Admin, Vorname, Nachname) 
            VALUES 
            (:email, :passwort, :admin, :vorname, :nachname) ');
        // Named parameter werden durch Werte ersetzt
        $ps->bindValue('email', $email);
        $ps->bindValue('passwort', $password);
        $ps->bindValue('admin', $admin ? 1 : 0);
        $ps->bindValue('vorname', $firstname);
        $ps->bindValue('nachname', $lastname);
        // preparedstatement an die DB
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    /**
     * @param string $email
     * @param string $password
     * @return Educator|bool
     */
    // wenn erfolgreich Paedagoge-Objekt zurück, sonst false
    function login(string $email, string $password) : Educator|bool{
        // den Pädagogen anhand der E-Mail Adresse laden
        $educator = $this->getEducatorByEmail($email);
        if($educator == false){
            return false;
        }

        // Passwort überprüfen
        if(!password_verify($password, $educator->password)){
            return false;
        }

        // den Paedagogen in der session eintragen
        $_SESSION['loggedin'] = true;
        $_SESSION['paedagogeid'] = $educator->id;
        $_SESSION['admin'] = $educator->admin;

        return $educator;
    }

    /**
     * @param $email
     * @return Educator|bool
     */
    // den Paedagogen anhand e-mail Adresse laden, sonst false
    function getEducatorByEmail($email) : Educator|bool {
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_paedagoge 
            WHERE Email = :email');

        $ps->bindValue('email', $email);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Paedagoge gefunden --> zurückgeben
            return new Educator($row['ID'], $row['Email'],
                $row['Passwort'], $row['Admin'], $row['Vorname'], $row['Nachname']);
        }
        // Paedagoge nicht gefunden --> false zurückgeben
        return false;
    }

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
    function isAdmin() : bool {
        if($this->isLoggedIn()
            && isset($_SESSION['admin'])
            && $_SESSION['admin'] === true)
        {
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     * @return Educator|bool
     */
    function getEducatorById(int $id) :  Educator|bool{
        $ps = $this->connection->prepare('
            SELECT * 
            FROM t_paedagoge 
            WHERE ID = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // wenn ein Eintrag gefunden wurde
        if($row = $ps->fetch()){
            // Paedagogen gefunden --> zurückgeben
            return new Educator($row['id'], $row['email'],
                $row['passwort'], $row['admin'], $row['vorname'], $row['nachname']);
        }
        return false;
    }

    /**
     * @return bool|Educator
     */
    function getCurrentEducator() : bool | Educator {
        return $this->getEducatorById($this->getCurrentEducatorId());
    }

    /**
     * @return int
     */
    function getCurrentEducatorId() : int {
        return $_SESSION['paedagogeid'];
    }

}

