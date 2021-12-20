<?php


class Kind
{
    public int $id;
    public string $vorname;
    public string $nachname;
    public string $geschlecht;
    public datetime $geburtsdatum;
    public datetime $eintrittsdatum;
    public int $geschwister;
    public int $fk_erziehungsberechtigte_id;
    public int $fk_paedagoge_id;

    public function __construct(int $id, string $vorname,string $nachname, string $geschlecht, datetime $geburtsdatum,
                                datetime $eintrittsdatum, int $geschwister, int $fk_erziehungsberechtigte_id, int $fk_paedagoge_id)
    {
        $this->id = $id;
        $this->vorname =$vorname;
        $this->nachname=$nachname;
        $this->geschlecht = $geschlecht;
        $this->geburtsdatum = $geburtsdatum;
        $this->eintrittsdatum = $eintrittsdatum;
        $this->geschwister=$geschwister;
        $this->fk_erziehungsberechtigte_id=$fk_erziehungsberechtigte_id;
        $this->fk_paedagoge_id=$fk_paedagoge_id;
    }

}
