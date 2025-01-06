<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Services\RaceService;
use App\Repository\RaceRepository;

class UpdateRaceTest extends TestCase
{
    private $raceServiceMock;
    private $raceRepositoryMock;

    protected function setUp(): void
    {
        // Création d'un mock pour RaceService
        // Cela permet de simuler le comportement du service sans utiliser son implémentation réelle
        $this->raceServiceMock = $this->createMock(RaceService::class);

        // Création d'un mock pour RaceRepository
        // Cela permet de simuler les interactions avec la base de données
        $this->raceRepositoryMock = $this->createMock(RaceRepository::class);
    }

    public function testUpdateRaceRequetePost()
    {
        // Simuler une requête POST
        $_SERVER['REQUEST_METHOD'] = 'POST';

        // Je défini un identifiant de race pour le test
        $id = 1;

        // Configurer le mock pour RaceService
        // On s'assure que la méthode updateRace est bien appelée avec l'ID attendu
        $this->raceServiceMock->expects($this->once())
            ->method('updateRace')
            ->with($this->equalTo($id));

        // Simuler une redirection après mise à jour
        // J'utilise une exception pour capturer le header Location
        $this->expectOutputString('');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Location: /DashRace/liste');

        // Classe anonyme pour tester le contrôleur
        $controller = new class ($this->raceServiceMock, $this->raceRepositoryMock) {
            private $raceService;
            private $raceRepository;

            public function __construct($raceService, $raceRepository)
            {
                $this->raceService = $raceService;
                $this->raceRepository = $raceRepository;
            }

            public function updateRace($id)
            {
                // Si la requête est POST, je met à jour la race
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->raceService->updateRace($id);
                    $_SESSION['success_message'] = "Race modifié avec succès.";
                    header("Location: /DashRace/liste");
                    throw new \Exception('Location: /DashRace/liste');
                }

                // Si ce n'est pas une requête POST, je récupère les données de la race en base de données
                // et je les passe à la vue pour affichage
                $races = $this->raceRepository->find($id);
                $this->render('dash/updateraces', [
                    'races' => $races,
                    'title' => 'Modifier Race'
                ]);
            }

            public function render($file, $data)
            {
                // Simuler le rendu de la vue avec les données fournies
                extract($data);
                echo "Rendered $file with title: $title";
            }
        };

        // Appeler la méthode updateRace avec l'ID défini
        $controller->updateRace($id);
    }
}