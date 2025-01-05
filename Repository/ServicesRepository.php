<?php

namespace App\Repository;

class ServicesRepository extends Repository
{
    public function __construct()
    {
        $this->table = 'Service';
    }

    public function createService($nom, $description, $id_user, $img)
    {
        //Préparation de la requete
        return $this->req(
            "INSERT INTO {$this->table} (nom, description, id_user, img) VALUES (:nom, :description, :id_user, :img)",
            [
                'nom' => $nom,
                'description' => $description,
                'id_user' => $id_user,
                'img' => $img
            ]
        );
    }

    public function AllServices()
    {
        return $this->req(
            "SELECT s.*, u.nom as User_nom
            FROM $this->table s
            JOIN User u ON s.id_User = u.id"
        )->fetchAll();
    }

    public function afficheService()
    {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->req($sql)->fetchAll();
        return $result;
    }
    public function selectServiceById($id)
    {
        return $this->req("SELECT * FROM $this->table WHERE id = ?", [$id])->fetch();
    }

    public function getRoles()
    {
        return $this->req('SELECT * FROM Role')->fetchAll();
    }

    // Supprimer un service
    public function deleteById($id)
    {
        return $this->delete($id);
    }
}