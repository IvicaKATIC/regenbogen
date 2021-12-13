<?php


class Kind
{
    public int $id;
    public string $vorname;
    public string $nachname;
    public int $geschlecht;
    public datetime $geburtsdatum;
    public datetime $eintrittsdatum;
    public int $geschwister;
    public int $fk_erziehungsberechtigte_id;
    public int $fk_paedagogen_id;

    public function __construct(int $id, string $vorname,string $nachname, int $geschlecht, datetime $geburtsdatum,
                                datetime $eintrittsdatum, int $geschwister, int $fk_erziehungsberechtigte_id, int $fk_paedagogen_id)
    {
        $this->id = $id;
        $this->vorname =$vorname;
        $this->nachname=$nachname;
        $this->geschlecht = $geschlecht;
        $this->geburtsdatum = $geburtsdatum;
        $this->eintrittsdatum = $eintrittsdatum;
        $this->geschwister=$geschwister;
        $this->fk_erziehungsberechtigte_id=$fk_erziehungsberechtigte_id;
        $this->fk_paedagogen_id=$fk_paedagogen_id;
    }

}
