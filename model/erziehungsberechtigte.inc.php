<?php

class Erziehungsberechtigte
{
    public int $id;
    public string $vorname;
    public string $nachname;

    public function __construct(int $id, string $vorname, string $nachname)
    {
        $this->id = $id;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
    }

}
