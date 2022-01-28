<?php

class Survey
{
    public int $id;
    public DateTime $date;
    public int $fk_child_id;

    public function __construct(int $id, DateTime $date, int $fk_child_id)
    {
        $this->id = $id;
        $this->date = $date;
        $this->fk_child_id = $fk_child_id;
    }
}
