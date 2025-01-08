<?php

namespace App\Repository;

class AnimauxRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Animal";
    }

    //Ajout d'animaux en base
    public function addAnimaux($nom, $age, $img, $id_race, $id_habitat, $description)
    {
        return $this->req(
            "INSERT INTO " . $this->table . " (nom, age, img, id_race, id_habitat, description)
             VALUES (:nom, :age, :img, :id_race, :id_habitat, :description)",
            [
                'nom' => $nom,
                'age' => $age,
                'img' => $img,
                'id_race' => $id_race,
                'id_habitat' => $id_habitat,
                'description' => $description,
            ]
        );
    }

    public function getAnimauxById($id)
    {
        $sql = "
        SELECT
            a.*,
            r.race AS race_nom,
            h.nom AS habitat_nom
        FROM
            {$this->table} a
        JOIN
            Race r ON a.id_race = r.id
        JOIN
            Habitat h ON a.id_habitat = h.id
        WHERE
            a.id = ?";
        return $this->req($sql, [$id])->fetch();
    }

    //obtentention animaux par id
    public function getAnimauxByUnivers($id_habitat)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_habitat = ?";
        return $this->req($sql, [$id_habitat])->fetchAll();
    }

    // compteur de visite par animaux
    public function incrementVisits(int $id): bool
    {
        $sql = 'UPDATE ' . $this->table . ' SET visite = visite + 1 WHERE id = ?';
        $stmt = $this->req($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    //supression des animaux
    public function deleteById($id)
    {
        return $this->delete($id);
    }
}