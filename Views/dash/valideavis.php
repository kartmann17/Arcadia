<?php
$css = 'dashindex';
?>

<div class="vide"></div>

<div class="container mt-5 mb-5 avis-container">
    <h2 class="mb-4">Valider des avis</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Étoiles</th>
                <th>Nom</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th class="text-center" style="width: 200px;">Actions</th>
            </tr>
        </thead>
        <?php foreach ($Avis as $avis): ?>
            <tbody>
                <tr>
                    <td><?= $avis->etoiles ?></td>
                    <td><?= $avis->nom ?></td>
                    <td><?= $avis->commentaire ?></td>
                    <td><?= $avis->date ?></td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <!-- Bouton Valider -->
                            <form action="/DashValideAvis/validerAvis" method="POST" class="w-100 mx-1" onsubmit="return confirm('Êtes-vous sûr de vouloir valider cet avis ?');">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="id" value="<?= $avis->id ?>">
                                <button type="submit" class="btn btn-success w-100">Valider</button>
                            </form>

                            <!-- Bouton Supprimer -->
                            <form action="/DashValideAvis/deleteAvis" method="POST" class="w-100 mx-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <input type="hidden" name="id" value="<?= $avis->id ?>">
                                <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>

    <div class="text-end">
        <a href="/dash" class="btn btn-secondary">Annuler</a>
    </div>
</div>