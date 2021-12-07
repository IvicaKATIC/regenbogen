<?php

class Fragen
{
    public int $id;
    public string $frage;
    public id $fk_bereich_id;

    public function __construct(int $id, string $frage, int $fk_bereich_id)
    {
        $this->id = $id;
        $this->frage = $frage;
        $this->fk_bereich_id = $fk_bereich_id;
    }
}
