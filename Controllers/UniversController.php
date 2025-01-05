<?php

namespace App\Controllers;

use App\Repository\UniversRepository;

class UniversController extends Controller
{
    public function index()
    {
        $title = "Nos Univers";
        $UniversRepository = new UniversRepository();
        $univers = $UniversRepository->findAll();
        $this->render('nos_univers/index', [
            'univers' => $univers,
            'title' => $title
        ]);
    }


    //affichage animanux par habitat dans page nos univers
    public function showAnimaux($id)
    {
        $universRepository = new UniversRepository();
        $univers = $universRepository->getDetails($id);
        $Habitat = $universRepository->find($id);

        $this->render('nos_univers/show', [
            'univer' => $univers,
            'Habitat' => $Habitat
            ]);
    }
}
