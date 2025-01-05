<?php

namespace App\Repository;

class ConnexionUserRepository extends Repository{

    public function __construct()
    {
        $this->table = "User";
    }
    public function recherche($email)
    {
        return $this->req(
            "SELECT u.id, u.nom, u.prenom, u.email, u.pass, r.role
            FROM User u
            JOIN Role r ON u.id_role = r.id
            WHERE u.email = :email",
            ['email' => $email]
        )->fetch();
    }
}