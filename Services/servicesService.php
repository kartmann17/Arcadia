<?php

namespace App\Services;

use App\Repository\ServicesRepository;


class servicesService
{
    public function updateService($serviceId)
    {
        // Récupérer les données POST
        $nom = $_POST['nom'] ?? null;
        $description = $_POST['description'] ?? null;
        $id_user = $_SESSION['id'] ?? null;
        $imgPath = null;


        $servicesRepository = new ServicesRepository();

        $existingService = $servicesRepository->find($serviceId);
        if (!$existingService) {
            throw new \Exception("Service introuvable.");
        }

        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $cloudinaryService = new CloudinaryService();
            $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);

            if (!$imgPath) {
                throw new \Exception("Erreur lors du téléversement de l'image sur Cloudinary.");
            }

            if (!empty($existingService->img)) {
                $publicId = $cloudinaryService->getPublicIdFromUrl($existingService->img);
                $cloudinaryService->deleteFile($publicId);
            }
        } else {
            $imgPath = $existingService->img;
        }

        $data = [
            'nom' => $nom ?? $existingService->nom,
            'description' => $description ?? $existingService->description,
            'img' => $imgPath,
            'id_user' => $id_user ?? $existingService->id_user,
        ];

        $success = $servicesRepository->update($serviceId, $data);

        if (!$success) {
            throw new \Exception("Erreur lors de la mise à jour du service.");
        }
    }
}
