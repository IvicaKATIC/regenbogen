<?php
require_once ('frage.inc.php');

class Prozentsatz
{
    public int $prozentsatz;
    public int $fk_kind_id;
    public Frage $frage;
    public int $fk_kompetenzerhebung_id;

    public function __construct(int $prozentsatz, int $fk_kind_id, Frage $frage, int $fk_kompetenzerhebung_id)
    {
        $this->prozentsatz = $prozentsatz;
        $this->fk_kind_id = $fk_kind_id;
        $this->frage = $frage;
        $this->fk_kompetenzerhebung_id = $fk_kompetenzerhebung_id;

    }




}