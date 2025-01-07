<?php

namespace App\Controllers;

use App\Repository\AvisRepository;
use App\Repository\HoraireRepository;

class MainController extends Controller
{
    public function index()
    {
        $title = "Zoo Arcadia";
        $AvisRepository = new AvisRepository();
        $Avis = $AvisRepository->findAll();

        $HoraireRepository = new HoraireRepository();
        $alias = 'horaires';
        $horaires = $HoraireRepository->findAll($alias);
        $this->render("acceuil/index", compact("Avis", "horaires", "title"));  //Affichage des avis validé depuis le dashboard sur la page d'accueil
    }

}
