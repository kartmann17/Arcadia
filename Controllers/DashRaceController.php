<?php

namespace App\Controllers;

use App\Repository\RaceRepository;
use App\Services\raceService;

class DashRaceController extends DashController
{
    // affichage de la liste des races
    public function liste()
    {
        $RaceRepository = new RaceRepository();
        $races = $RaceRepository->findAll();

        if (isset($_SESSION['id_User'])) {
            $title = "Liste Races";
            $this->render('dash/listeraces', [
                'races' => $races,
                'title' => $title
            ]);
        } else {
            http_response_code(404);
        }
    }

    // ajout des races
    public function ajoutRace()
    {
        $RaceRepository = new RaceRepository();
        $races = $RaceRepository->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $race = $_POST['race'] ?? '';


            // Vérification que tous les champs sont remplis
            if (!empty($race)) {

                // Appel du modèle pour l'insertion en base
                $RaceRepository = new RaceRepository();
                $result = $RaceRepository->addRace($race);

                if ($result) {
                    $_SESSION['success_message'] = "Race ajoutée avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout de la race.";
                }

                // Redirection après traitement
                header("Location: /dash");
                exit;
            }
        }
    }

    // suppresion des races
    public function deleteRace()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $RaceRepository = new RaceRepository();

                $result = $RaceRepository->deleteById($id);

                if ($result) {
                    $_SESSION['success_message'] = "La race a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de la race.";
                }
            } else {
                $_SESSION['error_message'] = "ID race invalide.";
            }

            // Redirection vers la dashboard
            header("Location: /dash");
            exit();
        }
    }

    // mise a jour de la race
    public function updateRace($id)
    {
        $raceService = new raceService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $raceService->updateRace($id);

            $_SESSION['success_message'] = "Race modifié avec succès.";
            header("Location: /DashRace/liste");
            exit;
        }

        $RaceRepository = new RaceRepository();
        $races = $RaceRepository->find($id);

        $title = "Modifier Race";
        $this->render('dash/updateraces', [
            'races' => $races,
            'title' => $title
        ]);
    }

    // affichage de la page ajout race
    public function index()
    {
        $title = "Ajout race";
        if (isset($_SESSION['id_User'])) {
            $this->render("dash/addrace", compact('title'));
        } else {
            http_response_code(404);
        }
    }
}
