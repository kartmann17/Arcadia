<?php
$css = 'nosanimaux';

// Préparation des tableaux associatifs pour un accès plus rapide
$racesMap = array_column($races, null, 'id');
$universMap = array_column($univers, null, 'id');
?>

<!-- En-tête de la page -->
<div class="vide"></div>
<h1 class="text-center mb-5" id="titre-animaux">Nos Animaux</h1>

<!-- Grille des cartes d'animaux -->
<div class="row row-cols-1 row-cols-md-3 g-5 m-auto mb-5">
    <?php foreach ($animaux as $animal):
        // Récupération directe des données liées
        $race = $racesMap[$animal->id_race] ?? null;
        $habitat = $universMap[$animal->id_habitat] ?? null;
    ?>
        <!-- Carte individuelle -->
        <div class="col">
            <article class="card m-auto w-75 h-100 d-flex flex-column" itemscope itemtype="http://schema.org/Animal">
                <!-- Image de l'animal -->
                <img
                    src="<?= htmlspecialchars($animal->img, ENT_QUOTES, 'UTF-8') ?>"
                    class="card-img-top image"
                    alt="Photo de <?= htmlspecialchars($animal->nom, ENT_QUOTES, 'UTF-8') ?>"
                    itemprop="image"
                    onerror="this.src='/Asset/Images/default-animal.jpg'"
                    loading="lazy"
                />

                <!-- Corps de la carte -->
                <div class="card-body overflow-auto text-center d-flex flex-column justify-content-between">
                    <div class="animal-details">
                        <!-- Informations principales -->
                        <h5 class="card-title" itemprop="name">
                            <?= htmlspecialchars($animal->nom, ENT_QUOTES, 'UTF-8') ?>
                        </h5>

                        <p class="card-text" itemprop="age">
                            Âge : <?= htmlspecialchars($animal->age, ENT_QUOTES, 'UTF-8') ?> ans
                        </p>

                        <!-- Race de l'animal -->
                        <p class="card-text" itemprop="breed">
                            Race : <?= $race ? htmlspecialchars($race->race, ENT_QUOTES, 'UTF-8') : 'Non défini' ?>
                        </p>

                        <!-- Habitat de l'animal -->
                        <p class="card-text" itemprop="habitat">
                            Habitat : <?= $habitat ? htmlspecialchars($habitat->nom, ENT_QUOTES, 'UTF-8') : 'Non défini' ?>
                        </p>
                    </div>

                    <!-- Bouton détails -->
                    <button
                        class="btn btm mt-3 w-100 mt-auto show-details"
                        data-animal-id="<?= htmlspecialchars($animal->id, ENT_QUOTES, 'UTF-8') ?>"
                        data-animal-name="<?= htmlspecialchars($animal->nom, ENT_QUOTES, 'UTF-8') ?>"
                        data-animal-age="<?= htmlspecialchars($animal->age, ENT_QUOTES, 'UTF-8') ?>"
                        data-animal-race="<?= $race ? htmlspecialchars($race->race, ENT_QUOTES, 'UTF-8') : 'Non défini' ?>"
                        data-animal-habitat="<?= $habitat ? htmlspecialchars($habitat->nom, ENT_QUOTES, 'UTF-8') : 'Non défini' ?>"
                        data-animal-description="<?= htmlspecialchars($animal->description, ENT_QUOTES, 'UTF-8') ?>">
                        Détails
                    </button>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal de détails -->
<div class="modal fade" id="animalModal" tabindex="-1" aria-labelledby="animalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="animalModalLabel">Description de l'animal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <p><strong>Nom :</strong> <span id="modal-animal-name"></span></p>
                <p><strong>Âge :</strong> <span id="modal-animal-age"></span> ans</p>
                <p><strong>Race :</strong> <span id="modal-animal-race"></span></p>
                <p><strong>Habitat :</strong> <span id="modal-animal-habitat"></span></p>
                <p><strong>Description :</strong> <span id="modal-animal-description"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<script src="Asset/Js/animalManager.js"></script>