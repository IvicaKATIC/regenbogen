<?php

class Kompetenzerhebung
{
    public int $id;
    public DateTime $datum;
    public int $fk_kind_id;

    public function __construct(int $id, DateTime $datum, int $fk_kind_id)
    {
        $this->id = $id;
        $this->datum = $datum;
        $this->fk_kind_id = $fk_kind_id;
    }
}
