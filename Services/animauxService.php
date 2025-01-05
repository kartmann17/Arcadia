<?php

namespace App\Services;

use App\Repository\AnimauxRepository;


class AnimauxService
{
    public function updateAnimaux($animauxId)
{
    // Récupérer les données POST
    $nom = $_POST['nom'] ?? null;
    $age = $_POST['age'] ?? null;
    $id_race = $_POST['id_race'] ?? null;
    $id_habitat = $_POST['id_habitat'] ?? null;
    $description = $_POST['description'] ?? null;
    $imgPath = null;

    $animauxRepository = new AnimauxRepository();

    // Récupérer les données existantes de l'animal
    $existingAnimal = $animauxRepository->find($animauxId);
    if (!$existingAnimal) {
        throw new \Exception("Animal introuvable.");
    }

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $cloudinaryService = new CloudinaryService();
        $imgPath = $cloudinaryService->validateAndUploadImage($_FILES['img']);

        if (!$imgPath) {
            throw new \Exception("Erreur lors du téléversement de l'image sur Cloudinary.");
        }

        // Supprimer l'ancienne image de Cloudinary
        if (!empty($existingAnimal->img)) {
            $publicId = $cloudinaryService->getPublicIdFromUrl($existingAnimal->img);
            $cloudinaryService->deleteFile($publicId);
        }
    } else {
        $imgPath = $existingAnimal->img;
    }

    $data = [
        'nom' => $nom ?? $existingAnimal->nom,
        'age' => $age ?? $existingAnimal->age,
        'img' => $imgPath,
        'id_race' => $id_race ?? $existingAnimal->id_race,
        'id_habitat' => $id_habitat ?? $existingAnimal->id_habitat,
        'description' => $description ?? $existingAnimal->description
    ];

    $success = $animauxRepository->update($animauxId, $data);

    if (!$success) {
        throw new \Exception("Erreur lors de la mise à jour de l'animal.");
    }
}

}