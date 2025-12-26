<?php
require_once 'user.php';
require_once 'animal.php';
require_once 'habitat.php';
require_once 'database.php';

class Admin extends User
{
    public function __construct($name = null, $firstName = null, $email = null, $password = null, $statut = null)
    {
        parent::__construct($name, $firstName, $email, $password, $statut);
    }

    public function updateStatut($status, $id){
        $db = Database::connect();
        $sqlUpdateStatut = "UPDATE utilisateur SET statuse = :status WHERE id_user = :id";
        $stmt = $db->prepare($sqlUpdateStatut);
        return $stmt->execute(['id'  => $id, 'status' => $status]);

    }

}
