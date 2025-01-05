<?php

namespace App\Models;

class AnimauxModel extends Model
{
    protected $id;
    protected $nom;
    protected $age;
    protected $img;
    protected $visite;
    protected $id_race;
    protected $id_habitat;
    protected $description;



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of visite
     */
    public function getVisite()
    {
        return $this->visite;
    }
    /**
     * Set the value of visite
     *
     * @return  self
     */
    public function setVisite($visite)
    {
        $this->visite = $visite;

        return $this;
    }

    /**
     * Get the value of id_race
     */
    public function getId_race()
    {
        return $this->id_race;
    }

    /**
     * Set the value of id_race
     *
     * @return  self
     */
    public function setId_race($id_race)
    {
        $this->id_race = $id_race;

        return $this;
    }

    /**
     * Get the value of id_habitat
     */
    public function getId_habitat()
    {
        return $this->id_habitat;
    }

    /**
     * Set the value of id_habitat
     *
     * @return  self
     */
    public function setId_habitat($id_habitat)
    {
        $this->id_habitat = $id_habitat;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

}
