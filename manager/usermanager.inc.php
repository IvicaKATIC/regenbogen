<?php
require_once __DIR__.'../model/Paedagogin.php';
class UserManager{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getUserByEmail(string $email){
        $statement = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        if ($row = $result->fetch()){
            $id = $row['ID'];
            $vorname = $row['Vorname'];
            $nachname = $row['Nachname'];
            $email = $row['Email'];
            $passwort = $row['Passwort'];
            $admin = $row['Admin'];
            $paedagogin = new Paedagogin($id, $vorname, $nachname,$email,$passwort,$admin);
            return $paedagogin;
        }
        return false;
    }

    public function  registerUser($email, $passwort){
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $this->connection->prepare("INSERT INTO paedagogen (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
        return $this->connection->lastInsertId();
    }
}
