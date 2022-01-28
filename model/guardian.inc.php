<?php

class Guardian
{
    public int $id;
    public string $email;
    public string $firstname;
    public string $lastname;

    public function __construct(int $id, string $email, string $firstname, string $lastname)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

}
