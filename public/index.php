<?php

use App\Autoloader;
use App\config\Main;

// Inclure l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Vérifier et charger le fichier .env uniquement s'il existe (pour local)
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

// Définir une constante avec le chemin racine du projet
define('ROOT', dirname(__DIR__));

// Enregistrer l'autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();

// Démarrer l'application
$app = new Main();
$app->start();