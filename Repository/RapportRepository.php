<?php

namespace App\Repository;

class RapportRepository extends Repository
{
    public function __construct()
    {
        $this->table = 'Rapport';
    }

    //enregistrement d'un rapport en base
    public function saveRapport($nom, $date, $status, $nourriture_reco, $grammage_reco, $sante, $repas_donnees, $quantite, $commentaire, $id_User, $id_animal)
    {
        return $this->req(
            "INSERT INTO {$this->table} (nom, date, status, nourriture_reco, grammage_reco, sante, repas_donnees, quantite, commentaire, id_User, id_animal)
            VALUES(:nom, :date, :status, :nourriture_reco, :grammage_reco, :sante, :repas_donnees, :quantite, :commentaire, :id_User, :id_animal)",
            attributs: [
                'nom' => $nom,
                'date' => $date,
                'status' => $status,
                'nourriture_reco' => $nourriture_reco,
                'grammage_reco' => $grammage_reco,
                'sante' => $sante,
                'repas_donnees' => $repas_donnees,
                'quantite' => $quantite,
                'commentaire' => $commentaire,
                'id_User' => $id_User,
                'id_animal' => $id_animal
            ]
        );
    }


    public function recherche($id_animal)
    {
        return $this->req(
            "SELECT h.*, a.nom as nom_animal
             FROM Rapport r
             JOIN Animal a On a.id_Animal = r.id_Animal
             WHERE a.id_Animal = :id_animal",
            ['id_animal' => $id_animal]
        )->fetch();
    }

    // Supprimer un rapport
    public function deleteById($id)
    {
        return $this->delete($id);
    }
}