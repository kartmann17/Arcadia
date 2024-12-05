<?php

namespace App\Models;

use App\config\MongoConnection;
use MongoDB\BSON\ObjectId;

class HorairesModel extends MongoConnection
{
    private $collection;


    public function __construct()
    {
        parent::__construct();
        $this->collection = $this->getCollection('Arcadia', 'horaires');
    }

    public function getHoraireById($id)
    {
        $result = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        // Convertion en objet
        return is_array($result) ? (object) $result : $result;
    }

    public function getAllHoraires()
    {
        return $this->collection->find([], ['sort' => ['index' => 1]])->toArray();
    }

    public function ajouterHoraire($jour, $ouverture, $fermeture)
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $index = array_search($jour, $jours) + 1;
        $horaire = [
            'jour' => $jour,
            'ouverture' => $ouverture,
            'fermeture' => $fermeture,
            'index' => $index
        ];
        $this->collection->insertOne($horaire)->getInsertedId();
    }

    public function deletehoraire($id)
    {
        $filter = ['_id' => new ObjectId($id)];
        $this->collection->deleteOne($filter);
    }

    public function updateHoraire($id, $jour, $ouverture, $fermeture)
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $index = array_search($jour, $jours) + 1;
        $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
        $update = [
            '$set' => [
                'jour' => $jour,
                'ouverture' => $ouverture,
                'fermeture' => $fermeture,
                'index' => $index
            ]
        ];
        $result = $this->collection->updateOne($filter, $update);
        return $result->getModifiedCount() > 0;
    }
}
