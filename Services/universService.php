<?php

namespace App\Services;

use App\Repository\UniversRepository;
use App\Models\UniversModel;

class universService
{
    public function updateUnivers($universId)
{
    $nom = $_POST['nom'] ?? null;
    $description = $_POST['description'] ?? null;
    $imgPath = null;

    $universRepository = new UniversRepository();
    $existingUnivers = $universRepository->find($universId);

    if (!$existingUnivers) {
        throw new \Exception("Univers introuvable.");
    }

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $cloudinaryService = new CloudinaryService();
        $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);

        if (!$imgPath) {
            throw new \Exception("Erreur lors du téléversement de l'image sur Cloudinary.");
        }

        if (!empty($existingUnivers->img)) {
            $publicId = $cloudinaryService->getPublicIdFromUrl($existingUnivers->img);
            $cloudinaryService->deleteFile($publicId);
        }
    } else {
        $imgPath = $existingUnivers->img;
    }

    $data = [
        'nom' => $nom ?? $existingUnivers->nom,
        'img' => $imgPath,
        'description' => $description ?? $existingUnivers->description,
    ];

    $success = $universRepository->update($universId, $data);

    if (!$success) {
        throw new \Exception("Erreur lors de la mise à jour de l'univers.");
    }
}
}