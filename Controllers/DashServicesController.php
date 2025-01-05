<?php

namespace App\Controllers;

use App\Repository\ServicesRepository;
use App\Services\CloudinaryService;
use App\Services\servicesService;

class DashServicesController extends DashController
{
    public function ajoutService()
    {
        $servicesRepository = new ServicesRepository();
        $cloudinaryService = new CloudinaryService();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imgPath = null;

            // Gestion de l'image avec Cloudinary
            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['img']['tmp_name'];

                // Téléversement sur Cloudinary
                $cloudinaryService = new CloudinaryService();
                $imgPath = $cloudinaryService->uploadFile($tmpName);

                if (!$imgPath) {
                    $_SESSION['error_message'] = "Erreur lors du téléversement de l'image.";
                    header("Location: /addservice");
                    exit();
                }
            }

            $data = [
                'nom' => $_POST['nom'] ?? null,
                'description' => $_POST['description'] ?? null,
                'img' => $imgPath,
                'id_user' => $_SESSION['id_user'],
            ];

            // Insertion en base de données
            $servicesRepository = new ServicesRepository();
            $result = $servicesRepository->createService(
                $data['nom'],
                $data['description'],
                $data['id_user'],
                $data['img'],
            );

            if ($result) {
                $_SESSION["success_message"] = "Service ajouté avec succès.";
            } else {
                $_SESSION["error_message"] = "Erreur lors de l'ajout du service.";
            }

            header("Location: /DashServices/liste");
            exit();
        } else {
            $_SESSION['error_message'] = "Tous les champs sont requis.";
            header("Location: /addservice");
            exit();
        }

        $this->render('dash/addservice', [
            'title' => "Ajout d'un service",
        ]);
    }



    public function updateServices($id)
    {
        $servicesRepository = new ServicesRepository();
        $servicesService = new ServicesService();

        $services = $servicesRepository->find($id);
        if (!$services) {
            throw new \Exception("Service introuvable.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicesService->updateService($id);

            $_SESSION["success_message"] = "Service modifié avec succès.";
            header("Location: /dash");
            exit;
        }

        if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'employé')) {
            $this->render('dash/updateservices', [
                'services' => $services,
                'title' => "Mise à jour service"
            ]);
        } else {

            http_response_code(403);
            echo "Accès interdit.";
            exit;
        }
    }


    // affichage de la liste des services
    public function liste()
    {
        $ServicesRepository = new ServicesRepository();
        $services = $ServicesRepository->findAll();

        if (isset($_SESSION['id_User'])) {
            $this->render("dash/listeservices", [
                "services" => $services
            ]);
        } else {
            http_response_code(404);
        }
    }


    //supression des services
    public function deleteService()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $servicesRepository = new ServicesRepository();
                $cloudinaryService = new CloudinaryService();

                // Trouver le service correspondant
                $service = $servicesRepository->find($id);

                if ($service) {
                    // Supprimer l'image associée si elle existe
                    if (!empty($service->img)) {
                        $publicId = $cloudinaryService->getPublicIdFromUrl($service->img);
                        $cloudinaryService->deleteFile($publicId);
                    }

                    // Supprimer le service de la base de données
                    $result = $servicesRepository->deleteById($id);

                    if ($result) {
                        $_SESSION['success_message'] = "Le service a été supprimé avec succès.";
                    } else {
                        $_SESSION['error_message'] = "Erreur lors de la suppression du service.";
                    }
                } else {
                    $_SESSION['error_message'] = "Service introuvable.";
                }
            } else {
                $_SESSION['error_message'] = "ID de service invalide.";
            }

            // Redirection vers le dashboard
            header("Location: /dash");
            exit();
        }

        // Si la méthode n'est pas POST, renvoyer une erreur
        http_response_code(405);
        echo "Méthode non autorisée.";
        exit();
    }


    public function index()
    {
        if (isset($_SESSION['id_User'])) {
            // Affichage de la page des services

            $this->render("dash/addservice");
        } else {
            http_response_code(404);
        }
    }
}
