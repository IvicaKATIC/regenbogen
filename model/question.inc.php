<?php

class Question
{
    public int $id;
    public string $text;
    public int $fk_area_id;

    public function __construct(int $id, string $text, int $fk_area_id)
    {
        $this->id = $id;
        $this->text = $text;
        $this->fk_area_id = $fk_area_id;
    }
}
