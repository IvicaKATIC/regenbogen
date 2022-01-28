<?php


class Child
{
    public int $id;
    public string $firstname;
    public string $lastname;
    public int $gender;
    public datetime $dob;
    public datetime $boarding;
    public int $siblings;
    public int $fk_guardian_id;
    public int $fk_educator_id;

    public function __construct(int      $id, string $firstname, string $lastname, int $gender, datetime $dob,
                                datetime $boarding, int $siblings, int $fk_guardian_id, int $fk_educator_id)
    {
        $this->id = $id;
        $this->firstname =$firstname;
        $this->lastname=$lastname;
        $this->gender = $gender;
        $this->dob = $dob;
        $this->boarding = $boarding;
        $this->siblings=$siblings;
        $this->fk_guardian_id=$fk_guardian_id;
        $this->fk_educator_id=$fk_educator_id;
    }

}
