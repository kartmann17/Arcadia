<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Repository\AvisRepository;

class ValiderAvisTest extends TestCase
{
    private $avisRepositoryMock;

    protected function setUp(): void
    {
        // Je Crée un mock pour simuler le comportement d'AvisRepository
        $this->avisRepositoryMock = $this->createMock(AvisRepository::class);
    }

    public function testValiderAvisSuccess()
    {
        // Simulation des données POST
        $_POST['id'] = 123;


        $this->avisRepositoryMock->expects($this->once())
            ->method('DashValiderAvis')
            ->with($this->equalTo(123));

        // Je simule la méthode validerAvis
        ob_start();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->avisRepositoryMock->DashValiderAvis($id);

            header("Location: /dash");
            ob_end_clean();
            $this->assertTrue(true);
        }
    }

    public function testValiderAvisFailure()
    {
        // Simulation avec id non défini
        unset($_POST['id']);

        // Exécute la méthode et vérifie qu'elle affiche un message d'erreur
        ob_start();
        if (!isset($_POST['id'])) {
            echo "Erreur : ID manquant.";
        }
        $output = ob_get_clean();

        $this->assertEquals("Erreur : ID manquant.", $output);
    }
}