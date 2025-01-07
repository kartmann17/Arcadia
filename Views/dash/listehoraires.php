<?php
$css = 'dashindex';
?>

<div class="vide"></div>
<div class="container mt-5 mb-5 horaires-container">
    <h2 class="mb-4">Horaires</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Jour</th>
                    <th>Heure d'ouverture</th>
                    <th>Heure de fermeture</th>
                    <th class="text-center" style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire): ?>
                    <tr>
                        <td><?= htmlspecialchars($horaire->jour, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($horaire->ouverture, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($horaire->fermeture, ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <!-- Bouton Modifier -->
                                <a href="/DashHoraire/updateHoraire/<?= htmlspecialchars($horaire->_id, ENT_QUOTES, 'UTF-8') ?>"
                                   class="btn btn-warning w-100 mx-1">Modifier</a>

                                <!-- Bouton Supprimer -->
                                <form action="/DashHoraire/deleteHoraire" method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');"
                                      class="w-100 mx-1">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($horaire->_id, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <a href="/dash" class="btn btn-secondary">Annuler</a>
    </div>
</div>