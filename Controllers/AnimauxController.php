<?php

namespace App\Controllers;

use App\Repository\AnimauxRepository;
use App\Repository\UniversRepository;
use App\Repository\RaceRepository;
class AnimauxController extends Controller
{
    public function index()
    {
        $title = "Nos Animaux";
        $AnimauxRepository = new AnimauxRepository();
        $animaux = $AnimauxRepository->findAll();
        $universRepository = new UniversRepository();
        $univers = $universRepository->findAll();
        $raceRepository = new RaceRepository();
        $races = $raceRepository->findAll();
        $this->render("animaux/index", [
            'animaux' => $animaux,
            'univers' => $univers,
            'races' => $races,
            'title' => $title
        ]);
    }

    // compteur de visite
    public function incrementVisits()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        http_response_code(405); // Méthode non autorisée
        echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id']) || intval($data['id']) <= 0) {
        http_response_code(400);
    }

    $animauxRepository = new AnimauxRepository();
    $success = $animauxRepository->incrementVisits(intval($data['id']));

    if ($success) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Visite incrémentée avec succès.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
    }
}
}


