<?php

class Paedagogen
{
    public int $id;
    public string $vorname;
    public string $nachname;
    public string $email;
    public string $passwort;
    public bool $admin;

    public function __construct(int $id, string $vorname, string $nachname, string $email, string $passwort, bool $admin)
    {
        $this->id = $id;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->passwort = $passwort;
        $this->admin = $admin;
    }

}