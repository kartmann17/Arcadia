<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Repository\ConnexionUserRepository;

class ConnexionTest extends TestCase
{
    // Mock de la classe ConnexionUserRepository pour simuler les interactions avec la base de données
    private $repositoryMock;

    protected function setUp(): void
    {
        // Initialisation du mock pour la classe ConnexionUserRepository
        $this->repositoryMock = $this->createMock(ConnexionUserRepository::class);
    }

    public function testConnexionSuccess()
    {
        // Je simule une requête POST avec des données utilisateur valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'test@example.com';
        $_POST['pass'] = 'password123';

        // Simulation de la recherche d'un utilisateur avec l'email fourni
        $this->repositoryMock->method('recherche')
            ->with('test@example.com') // L'email est passé comme argument
            ->willReturn((object)[
                'id' => 1,
                'nom' => 'Doe',
                'prenom' => 'John',
                'role' => 'admin',
                'pass' => password_hash('password123', PASSWORD_DEFAULT), // Mot de passe haché pour comparaison
            ]);

        // Simulation de l'initialisation de la session
        session_start();
        $_SESSION = []; // Je vide la session pour éviter les interférences

        // Je crée une classe anonyme pour encapsuler la logique de connexion
        $connexion = new class($this->repositoryMock) {
            private $repository;

            // Le repository est injecté via le constructeur pour permettre les tests
            public function __construct($repository)
            {
                $this->repository = $repository;
            }

            // Méthode de connexion à tester
            public function connexion()
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Je nettoie et valide l'email
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $pass = trim($_POST['pass']); // Je nettoie le mot de passe

                    // Recherche de l'utilisateur correspondant à l'email
                    $user = $this->repository->recherche($email);

                    // Vérification de l'utilisateur et du mot de passe
                    if ($user && password_verify($pass, $user->pass)) {
                        // Je régénère l'ID de session pour plus de sécurité
                        session_regenerate_id(true);

                        // Stockage des informations utilisateur dans la session
                        $_SESSION['id_User'] = $user->id;
                        $_SESSION['nom'] = htmlspecialchars($user->nom, ENT_QUOTES, 'UTF-8');
                        $_SESSION['prenom'] = htmlspecialchars($user->prenom, ENT_QUOTES, 'UTF-8');
                        $_SESSION['role'] = htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8');
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génération d'un token CSRF

                        return true; // Connexion réussie
                    } else {
                        return false; // Échec de la connexion
                    }
                }
            }
        };

        // Je teste la méthode de connexion
        $result = $connexion->connexion();

        // Vérifications des assertions pour s'assurer du bon fonctionnement
        $this->assertTrue($result); // La connexion doit réussir
        $this->assertNotEmpty($_SESSION['id_User']); // L'ID utilisateur doit être présent dans la session
        $this->assertEquals('Doe', $_SESSION['nom']); // Vérification du nom
        $this->assertEquals('John', $_SESSION['prenom']); // Vérification du prénom
        $this->assertEquals('admin', $_SESSION['role']); // Vérification du rôle
        $this->assertNotEmpty($_SESSION['csrf_token']); // Le token CSRF doit être généré
    }
}