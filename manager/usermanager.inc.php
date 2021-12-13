<?php
require_once __DIR__ . '/../model/paedagogen.inc.php';
class UserManager {
    // PDO $connection ist die Verbindung zur Datenbank
    private PDO $connection;
    function __construct(PDO $connection){
        $this->connection = $connection;
    }

    function createUser(string $name, string $email, string $passwort){
        // Passwort hashen
        $passwort = password_hash($passwort, PASSWORD_DEFAULT);
        // neu angelegte user sind kein admin
        $admin = 0;

        // Gibt es schon einen User mit dieser E-Mail Adresse?
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }

        // User in DB einfügen
        $ps = $this->connection->prepare('
            INSERT INTO users 
            (name, email, passwort, admin) 
            VALUES 
            (:name, :email, :passwort, :admin) ');
        // Named parameter (z. B. :name) durch den Wert ersetzen
        $ps->bindValue('name', $name);
        $ps->bindValue('email', $email);
        $ps->bindValue('passwort', $passwort);
        $ps->bindValue('admin', $admin);
        // Statement an die Datenbank senden
        $ps->execute();
        // Welche ID wurde generiert?
        return $this->connection->lastInsertId();
    }

    // Gibt bei erfolgreichem Login das User-Objekt zurück,
    // ansonsten false
    function login(string $email, string $password) : User|bool{
        // User anhand der E-Mail Adresse laden
        $user = $this->getUserByEmail($email);
        if($user == false){
            return false;
        }

        // Passwort überprüfen
        if(!password_verify($password, $user->passwort)){
            return false;
        }

        // In der Session den User eintragen
        // loggedin=true userid=<userid>
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $user->id;
        $_SESSION['admin'] = $user->admin;

        // User zurückgeben
        return $user;
    }

    // Lädt User-Objekt anhand der E-Mail Adresse,
    // ansonsten false
    function getUserByEmail($email) : User|bool {
        $ps = $this->conn->prepare('
            SELECT * 
            FROM users 
            WHERE email = :email');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('email', $email);
        // Statement an die Datenbank senden
        $ps->execute();
        // Wurde ein Eintrag gefunden?
        if($row = $ps->fetch()){
            // USer gefunden --> zurückgeben
            return new User($row['ID'], $row['name'],
                $row['email'], $row['passwort'], $row['admin']);
        }
        // User nicht gefunden --> false zurückgeben
        return false;
    }

    function isLoggedIn() : bool {
        // schauen ob Session-Variablen vorhanden sind
        // && schauen ob die Variable auf TRUE gesetzt wurde
        if(isset($_SESSION['loggedin'])
            && $_SESSION['loggedin'] === true
            && isset($_SESSION['userid'])){
            return true;
        }
        return false;
    }

    function logout() {
        if($this->isLoggedIn()){
            $_SESSION['loggedin'] = false;
            $_SESSION['userid'] = '';
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

    function getUserById(int $id) :  User|bool{
        $ps = $this->conn->prepare('
            SELECT * 
            FROM users 
            WHERE id = :id');
        // Named Parameter mit dem Wert ersetzen
        $ps->bindValue('id', $id);
        // Statement an die Datenbank senden
        $ps->execute();
        // Wurde ein Eintrag gefunden?
        if($row = $ps->fetch()){
            // USer gefunden --> zurückgeben
            return new User($row['ID'], $row['name'],
                $row['email'], $row['passwort'], $row['admin']);
        }
        // User nicht gefunden --> false zurückgeben
        return false;
    }

    function getCurrentUser() : bool | User {
        return $this->getUserById($this->getCurrentUserId());
    }

    function getCurrentUserId() : int {
        return $_SESSION['userid'];
    }

}

