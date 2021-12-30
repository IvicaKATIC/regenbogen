<?php

require_once __DIR__ . '/../model/kompetenzerhebung.inc.php';

class KompetenzerhebungManager
{
    private PDO $connection;

    function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    function createKompetenzerhebung(datetime $datum, int $fk_kind_id): bool
    {
        $ps = $this->connection->prepare('
            INSERT INTO t_kompetenzerhebung 
            (Datum, FK_Kind_ID) 
            VALUES 
            (:datum, :fk_kind_id) ');
        $ps->bindValue('datum', $datum->format('d.m.Y'));
        $ps->bindValue('fk-kind_id', $fk_kind_id->fk_kind_id);
        return $ps->execute();
    }
}

