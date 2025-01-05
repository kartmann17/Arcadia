<?php

namespace App\Models;


class AvisModel extends Model
{
    protected $id;
    protected $etoiles;
    protected $nom;
    protected $commentaire;
    protected $date;
    protected $valide;


    /**
     * Set the value of valide
     *
     * @return  self
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }
}
