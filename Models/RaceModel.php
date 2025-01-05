<?php

namespace App\Models;


class RaceModel extends Model
{
    protected $id;
    protected $race;


    public function getId()
    {
        return $this->id;
    }

    public function getRace()
    {
        return $this->race;
    }

    public function setRace($race)
    {
        $this->race = $race;
        return $this;
    }
}
