<?php
require_once ('question.inc.php');

class Percentage
{
    public int $value;
    public int $fk_child_id;
    public Question $question;
    public int $fk_survey_id;

    public function __construct(int $value, int $fk_child_id, Question $question, int $fk_survey_id)
    {
        $this->value = $value;
        $this->fk_child_id = $fk_child_id;
        $this->question = $question;
        $this->fk_survey_id = $fk_survey_id;

    }




}