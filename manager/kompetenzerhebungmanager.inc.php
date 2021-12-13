<?php

require_once __DIR__ . '/../model/kompetenzerhebung.inc.php';

class KompetenzerhebungManager
{
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function createTermin(DateTime $termin, User $user, Immobilie $immo): bool
    {
        $ps = $this->conn->prepare('
            INSERT INTO besichtigung 
            (user_id, immobilien_id, termin) 
            VALUES 
            (:userId, :immobilienId, :termin) ');
        $ps->bindValue('userId', $user->id);
        $ps->bindValue('immobilienId', $immo->id);
        $ps->bindValue('termin', $termin->format('Y-m-d H:i:s'));
        return $ps->execute();
    }
}

