<?php

class Erziehungsberechtigte
{
    public int $id;
    public string $email;
    public string $vorname;
    public string $nachname;

    public function __construct(int $id, string $email, string $vorname, string $nachname)
    {
        $this->id = $id;
        $this->email = $email;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
    }

}
