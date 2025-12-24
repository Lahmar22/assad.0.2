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

    public function getAllUser()
    {
        $db = Database::connect();
        $allUser = "SELECT id_user, nom, prenom, email, role, statuse FROM utilisateur";
        $stmt = $db->prepare($allUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addAnimal(Animal $animal)
    {
        $Add_animal = "INSERT INTO animaux (nomAnimal, espèce, alimentation, image, paysorigine, descriptioncourte, id_habitat)
        VALUES(?, ?, ?, ?, ?, ?, ? )";

        $db = Database::connect();
        $stmt = $db->prepare($Add_animal);
        return $stmt->execute([
            $animal->getNomAnimal(),
            $animal->getEspece(),
            $animal->getAlimentation(),
            $animal->getImage(),
            $animal->getPaysOrigine(),
            $animal->getDescriptionCourte(),
            $animal->getIdHabitat()
        ]);
    }

    public function addHabitat(Habitat $habitat) {
        $Add_habitat = "INSERT INTO habitats (nomHabitat, typeclimat, description, zonezoo)
        VALUES(?, ?, ?, ?)";

        $db = Database::connect();
        $stmt = $db->prepare($Add_habitat);
        return $stmt->execute([
            $habitat->getNomHabitat(),
            $habitat->getTypeclimat(),
            $habitat->getDescription(),
            $habitat->getZonezoo()
           
        ]);
    }

    public function updateAnimal() {}

    public function updateHabitat() {}

    public function removeAnimal() {}

    public function removeHabitat() {}
}
