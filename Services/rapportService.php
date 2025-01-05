<?php
namespace App\Services;

use App\Repository\RapportRepository;
use App\Models\RapportModel;

class RapportService
{
    public function updateRapport($rapportId)
    {
        // Récupérer les données de la requête POST
        $nom = $_POST['nom'] ?? null;
        $date = $_POST['date'] ?? null;
        $status = $_POST['status'] ?? null;
        $nourriture_reco = $_POST['nourriture_reco'] ?? null;
        $grammage_reco = $_POST['grammage_reco'] ?? null;
        $sante = $_POST['sante'] ?? null;
        $repas_donnees = $_POST['repas_donnees'] ?? null;
        $quantite = $_POST['quantite'] ?? null;
        $commentaire = $_POST['commentaire'] ?? null;
        $id_User = $_SESSION['id_User'] ?? null;
        $id_animal = $_POST['id_animal'] ?? null;


        if (empty($nom) || strlen($nom) < 2) {
            throw new \Exception("Le nom de l'animal est obligatoire et doit comporter au moins 2 caractères.");
        }

        if (empty($id_User)) {
            throw new \Exception("L'utilisateur doit être identifié pour effectuer cette action.");
        }

        $data = [
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
            'id_animal' => $id_animal,
        ];

        $rapportModel = new RapportModel();
        $rapportModel->hydrate($data);

        $rapportRepository = new RapportRepository();
        $success = $rapportRepository->update($rapportId, $data);

        if (!$success) {
            throw new \Exception("Erreur lors de la mise à jour du rapport.");
        }

        return $success;
    }
}