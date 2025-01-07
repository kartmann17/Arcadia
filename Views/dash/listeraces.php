<?php
$css = 'dashindex';
?>

<div class="vide"></div>
<div class="container mt-5 mb-5 races-container">
    <h2 class="mb-4">Gestion des Races</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th class="text-center" style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($races as $race): ?>
                    <tr>
                        <td><?= htmlspecialchars($race->race, ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'vétérinaire')): ?>
                                <div class="d-flex justify-content-between">
                                    <!-- Bouton Modifier -->
                                    <a href="/DashRace/updateRace/<?= htmlspecialchars($race->id, ENT_QUOTES, 'UTF-8') ?>"
                                       class="btn btn-warning w-100 mx-1">Modifier</a>

                                    <!-- Bouton Supprimer -->
                                    <form action="/DashRace/deleteRace" method="POST"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette race ?');"
                                          class="w-100 mx-1">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($race->id, ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                                    </form>
                                </div>
                            <?php endif; ?>
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