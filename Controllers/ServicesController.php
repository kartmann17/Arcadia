<?php

namespace App\Controllers;

use App\Repository\ServicesRepository;


class ServicesController extends Controller
{
    public function index()
    {
        $title = "Nos Services";
        $ServicesRepository = new ServicesRepository();
        $services = $ServicesRepository->findAll();
        // Affichage de la page des services
        $this->render("nos_services/index", ["services" => $services, "title" => $title]);
    }
}
