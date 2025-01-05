<?php

namespace App\Controllers;

use App\Repository\UniversRepository;
use App\Services\universService;
use App\Services\CloudinaryService;

class DashUniversController extends DashController
{
    //Ajout d'un habitat (univer)
    public function ajoutUnivers()
    {
        $universRepository = new UniversRepository();
        $cloudinaryService = new CloudinaryService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = null;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];

                $cloudinaryService = new CloudinaryService();
                $imgPath = $cloudinaryService->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /addunivers");
                    exit;
                }
            }
            // Hydratation des données
            $data = [
                'nom' => $_POST['nom'] ?? null,
                'img' => $imgPath,
                'description' => $_POST['description'] ?? null,
            ];


            // Insertion en base de données
            $UniversRepository = new UniversRepository();
            $result = $UniversRepository->addUnivers(
                $data['nom'],
                $data['img'],
                $data['description']
            );

            if ($result) {
                $_SESSION["success_message"] = "Habitat ajouté avec succès.";
            } else {
                $_SESSION["error_message"] = "Erreur lors de l'ajout de l'habitat.";
            }

            // Redirection après traitement
            header("Location: /DashUnivers/liste");
            exit();
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
            $this->render('dash/index', [
                'section' => 'addunivers'
            ]);
        } else {
            http_response_code(404);
        }
    }


    //mise à jour des habitat (univer)
    public function updateUnivers($id)
    {
        $UniversService = new UniversService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Appel du service pour gerer le téléversement d'image et la mise a jour
            $UniversService->updateUnivers($id);

            $_SESSION["success_message"] = "Univer modifié avec succès.";
            header("Location: /DashUnivers/liste");
            exit;
        }

        $UniversRepository = new UniversRepository();
        $univers = $UniversRepository->find($id);

        if (!$univers) {
            throw new \Exception("Univer introuvable.");
        }

        $this->render('dash/updateunivers', [
            'univers' => $univers
        ]);
    }

    // Suppression des habitats (univer)
    public function deleteUniver()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $universRepository = new UniversRepository();
                $cloudinaryService = new CloudinaryService();

                $univers = $universRepository->find($id);

                if ($univers) {
                    if (!empty($univers->img)) {
                        $publicId = $cloudinaryService->getPublicIdFromUrl($univers->img);
                        $cloudinaryService->deleteFile($publicId);
                    }

                    $result = $universRepository->deleteById($id);

                    if ($result) {
                        $_SESSION['success_message'] = "L'habitat a été supprimé avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression de l'habitat.";
                    }
                } else {
                    $_SESSION['error_message'] = "Habitat introuvable.";
                }
            } else {
                $_SESSION['error_message'] = "ID d'habitat invalide.";
            }

            header("Location: /dash");
            exit();
        }
    }

    // Liste des habitats (univer)
    public function liste()
    {
        $UniversRepository = new UniversRepository();
        $univers = $UniversRepository->findAll();

        if (isset($_SESSION['id_User'])) {
            $this->render('dash/listeunivers', [
                'univers' => $univers
            ]);
        } else {
            http_response_code(404);
        }
    }

    public function index()
    {
        if (isset($_SESSION['id_User'])) {
            // Affichage de la vue d'ajout des animaux
            $this->render("dash/addunivers");
        } else {
            http_response_code(404);
        }
    }
}
