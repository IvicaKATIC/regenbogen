<?php

require_once __DIR__ . '/../model/kompetenzerhebung.inc.php';

class KompetenzerhebungManager
{
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function createKompetenzerhebung(int $id, date $datum, int $fk_kind_id): bool
    {
        $ps = $this->connection->prepare('
            INSERT INTO t_kompetenzerhebung 
            (id, datum, fk_kind_id) 
            VALUES 
            (:id, :datum, :fk_kind_id) ');
        $ps->bindValue('id', $id->id);
        $ps->bindValue('datum', $datum->format('Y-m-d H:i:s'));
        $ps->bindValue('fk-kind_id', $fk_kind_id->fk_kind_id);
        return $ps->execute();
    }
}

