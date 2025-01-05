<?php

namespace App\Services;

use App\Repository\RaceRepository;
use App\Models\RaceModel;

class raceService
{
    public function updateRace($raceId)
    {

        $race = $_POST['race'] ?? null;

        if (empty($race) || strlen($race) < 2) {
            throw new \Exception("Le nom de la race est obligatoire et doit comporter au moins 2 caractères.");
        }

        $data = [
            'race' => $race
        ];

        // Hydrater le modèle avec les nouvelles données
        $raceModel = new RaceModel();
        $raceModel->hydrate($data);

        $raceRepository = new RaceRepository();
        $success = $raceRepository->update($raceId, $data);

        // Vérification du succès de la mise à jour
        if (!$success) {
            throw new \Exception("Erreur lors de la mise à jour de la race.");
        }
    }
}
