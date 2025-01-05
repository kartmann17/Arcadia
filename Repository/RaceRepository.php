<?php

namespace App\Repository;

class RaceRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Race";
    }

    public function addRace($race)
    {
        return $this->req(
            "INSERT INTO " . $this->table . "(race) VALUES (:race)",
            [
                'race' => $race
            ]
        );
    }


    public function deleteById($id)
    {
        return $this->delete($id);
    }
}