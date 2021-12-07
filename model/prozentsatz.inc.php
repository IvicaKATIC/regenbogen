<?php

class Prozentsatz
{
    public int $prozentsatz;
    public int $fk_kind_id;
    public int $fk_fragen_id;
    public int $fk_kompetenzerhebung_id;

    public function __construct(int $prozentsatz, int $fk_kind_id, int $fk_fragen_id, int $fk_kompetenzerhebung_id)
    {
        $this->prozentsatz = $prozentsatz;
        $this->fk_kind_id = $fk_kind_id;
        $this->fk_fragen_id = $fk_fragen_id;
        $this->fk_kompetenzerhebung_id = $fk_kompetenzerhebung_id;
    }

}