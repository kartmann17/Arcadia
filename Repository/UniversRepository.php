<?php

namespace App\Repository;

class UniversRepository extends Repository
{
    public function __construct()
    {
        $this->table = "Habitat";
    }

    //Ajout d'univers
    public function addUnivers($nom, $img, $description)
    {
        return $this->req(
            "INSERT INTO " . $this->table . " (nom, img, description)
            VALUES (:nom, :img, :description)",
            [
                'nom' => $nom,
                'img' => $img,
                'description' => $description,
            ]
        );
    }

    //obtentention univers par id
    public function getUniversById($id)
    {
        return $this->req("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }

    public function getDetails($id)
    {
        $sql = "SELECT r.race, rp.*, a.nom as nom_animal, a.age, a.img as img_animal, u.nom as nom_Habitat, u.img as img_Habitat, u.description as description_Habitat
            FROM {$this->table} u
            LEFT JOIN Animal a ON u.id = a.id_habitat
            LEFT JOIN Rapport rp ON a.id = rp.id_animal
            LEFT JOIN Race r ON r.id = a.id_race
            WHERE u.id = ?";
        return $this->req($sql, [$id])->fetchAll();
    }

    //suppresions de l'univers par l'id
    public function deleteById($id)
    {
        return $this->delete($id);
    }
}
