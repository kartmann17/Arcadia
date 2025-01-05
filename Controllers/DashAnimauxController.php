<?php

namespace App\Controllers;

use App\Repository\AnimauxRepository;
use App\Services\animauxService;
use App\Repository\UniversRepository;
use App\Repository\RaceRepository;
use App\Services\CloudinaryService;

class DashAnimauxController extends DashController
{
    public function ajoutAnimaux()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = null;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];


                $cloudinaryService = new CloudinaryService();
                $imgPath = $cloudinaryService->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /addanimaux");
                    exit;
                }
            }

            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'age' => $_POST['age'] ?? null,
                'id_race' => $_POST['id_race'] ?? null,
                'id_habitat' => $_POST['id_habitat'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath,
            ];

            if (empty($data['nom']) || strlen($data['nom']) < 2) {
                $_SESSION['error_message'] = "Le nom est obligatoire et doit comporter au moins 2 caractères.";
                header("Location: /addanimaux");
                exit;
            }

            if (empty($data['age']) || empty($data['id_race']) || empty($data['id_habitat']) || empty($data['description'])) {
                $_SESSION['error_message'] = "Tous les champs obligatoires doivent être remplis.";
                header("Location: /addanimaux");
                exit;
            }

            // Insertion en base de données
            $animauxRepository = new AnimauxRepository();
            $result = $animauxRepository->addAnimaux(
                $data['nom'],
                $data['age'],
                $data['img'],
                $data['id_race'],
                $data['id_habitat'],
                $data['description']
            );

            if ($result) {
                $_SESSION['success_message'] = "Animal ajouté avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de l'animal.";
            }

            // Redirection après traitement
            header("Location: /dash");
            exit;
        }

        $universRepository = new UniversRepository();
        $raceRepository = new RaceRepository();
        $this->render('dash/addanimaux', [
            'univers' => $universRepository->findAll(),
            'races' => $raceRepository->findAll(),
            'title' => "Ajout d'un animal",
        ]);
    }

    public function deleteAnimal()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $animauxRepository = new AnimauxRepository();
            $cloudinaryService = new CloudinaryService();

            $animal = $animauxRepository->find($id);

            if ($animal) {
                if (!empty($animal->img)) {
                    $publicId = $cloudinaryService->getPublicIdFromUrl($animal->img);
                    $cloudinaryService->deleteFile($publicId);
                }

                $result = $animauxRepository->deleteById($id);

                if ($result) {
                    $_SESSION['success_message'] = "L'animal a été supprimé avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de la suppression de l'animal.";
                }
            } else {
                $_SESSION['error_message'] = "Animal introuvable.";
            }
        } else {
            $_SESSION['error_message'] = "ID d'animal invalide.";
        }

        header("Location: /dash");
        exit();
    }
}

    // affichage de la liste des animaux dans l'onglet liste
    public function liste()
    {
        $title = "Liste Animaux";
        $AnimauxRepository = new AnimauxRepository();
        $animaux = $AnimauxRepository->findAll();
        if (isset($_SESSION['id_User'])) {
            $this->render('dash/listeanimaux',
            [
                'animaux' => $animaux,
                'title' => $title
            ]);
        } else {
            http_response_code(404);
        }
    }

    //mise a jour des animaux
    public function updateAnimal($id)
    {
        $universRepository = new UniversRepository();
        $raceRepository = new RaceRepository();
        $animauxService = new AnimauxService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Appeler le service pour gérer le téléversement d'image et la mise à jour
            $animauxService->updateAnimaux($id);

            // Rediriger après succès
            $_SESSION['success_message'] = "Animal modifié avec succès.";
            header("Location: /DashAnimaux/liste");
            exit;
        }

        // Charger les données pour la vue
        $univers = $universRepository->findAll();
        $races = $raceRepository->findAll();
        $animauxRepository = new AnimauxRepository();
        $animaux = $animauxRepository->find($id);

        if (!$animaux) {
            throw new \Exception("Animal introuvable.");
        }

        // Afficher la vue de mise à jour
        $this->render('dash/updateanimaux', [
            'animaux' => $animaux,
            'univers' => $univers,
            'races' => $races,
            'title' => "Mise à jour animaux",
        ]);
    }



    // affichage de la page des animaux dans le dashboard
    public function index()
    {

        $AnimauxRepository = new AnimauxRepository();
        $animaux = $AnimauxRepository->findAll();
        $universRepository = new UniversRepository();
        $univers = $universRepository->findAll();
        $raceRepository = new RaceRepository();
        $races = $raceRepository->findAll();
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue d'ajout des animaux
            $this->render("dash/addanimaux", compact('animaux', 'univers', 'races'));
        } else {
            http_response_code(404);
        }
    }
}
