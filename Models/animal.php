<?php
require_once 'database.php';

class Animal
{
    private $nomAnimal;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $descriptioncourte;
    private $idHabitat;


    public function __construct($nomAnimal = null, $espece = null, $alimentation = null, $image = null, $paysorigine = null, $descriptioncourte = null, $idHabitat = null)
    {;
        $this->nomAnimal = $nomAnimal;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->descriptioncourte = $descriptioncourte;
        $this->idHabitat= $idHabitat;
    }

    public function getAllAnimaux()
    {
        $db = Database::connect();
        $allAnimal = "SELECT animaux.id, animaux.nomAnimal, animaux.espèce, animaux.alimentation, animaux.image, animaux.paysorigine, animaux.descriptioncourte, habitats.nomHabitat 
        FROM animaux INNER JOIN habitats ON animaux.id_habitat = habitats.id_habitat";
        $stmt = $db->prepare($allAnimal);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAnimauxRecherche($filterPaysOrigin, $filter_habitat)
    {
        $db = Database::connect();
        $sqlAnimalFiltre = "SELECT animaux.id, animaux.nomAnimal, animaux.espèce, animaux.alimentation, animaux.image, animaux.paysorigine, animaux.descriptioncourte, habitats.nomHabitat 
        FROM animaux INNER JOIN habitats ON animaux.id_habitat = habitats.id_habitat  
        WHERE animaux.paysorigine = :filterPaysOrigin AND habitats.nomHabitat = :filter_habitat ";

        $stmt = $db->prepare($sqlAnimalFiltre);
        $stmt->execute(['filterPaysOrigin' => $filterPaysOrigin, 'filter_habitat' => $filter_habitat]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPaysOrigin() {
        $db = Database::connect();
        $sqlPaysOrigin = "SELECT paysorigine FROM animaux GROUP BY paysorigine";
        $stmt = $db->prepare($sqlPaysOrigin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

    public function addAnimal(Animal $animal)
    {

        $sqlAnimal = "INSERT INTO animaux (nomAnimal, espèce, alimentation, image, paysorigine, descriptioncourte, id_habitat)
                VALUES(?, ?, ?, ?, ?, ?, ?)";

        $db = Database::connect();
        $stmt = $db->prepare($sqlAnimal);

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

    public function updateAnimal(Animal $animal, $id)
    {
        $sqlupdateAnimal = "UPDATE animaux SET nomAnimal = :nom, espèce = :espece, alimentation = :alimentation, image = :image, paysorigine = :paysorigine, descriptioncourte = :descriptioncourte, id_habitat = :habitat 
            WHERE id = $id";

        $db = Database::connect();
        $stmt = $db->prepare($sqlupdateAnimal);

        return $stmt->execute([
            'nom' => $animal->getNomAnimal(),
            'espece' => $animal->getEspece(),
            'alimentation' => $animal->getAlimentation(),
            'image' => $animal->getImage(),
            'paysorigine' => $animal->getPaysorigine(),
            'descriptioncourte' => $animal->getDescriptioncourte(),
            'habitat' => $animal->getIdHabitat()
        ]);
    }

    public function removeAnimal($id)
    {
        $delete_animal = "DELETE FROM animaux WHERE id = :id";

        $db = Database::connect();
        $stmt = $db->prepare($delete_animal);
        return $stmt->execute(['id' => $id]);
    }

    


    public function getNomAnimal()
    {
        return $this->nomAnimal;
    }
    public function setNomAnimal($nomAnimal)
    {
        $this->nomAnimal = $nomAnimal;
    }

    public function getEspece()
    {
        return $this->espece;
    }
    public function setEspece($espece)
    {
        $this->espece = $espece;
    }

    public function getAlimentation()
    {
        return $this->alimentation;
    }
    public function setAlimentation($alimentation)
    {
        $this->alimentation = $alimentation;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getPaysorigine()
    {
        return $this->paysorigine;
    }
    public function setPaysorigine($paysorigine)
    {
        $this->paysorigine = $paysorigine;
    }

    public function getDescriptioncourte()
    {
        return $this->descriptioncourte;
    }
    public function setDescriptioncourte($descriptioncourte)
    {
        $this->descriptioncourte = $descriptioncourte;
    }

    public function getIdHabitat()
    {
        return $this->idHabitat;
    }
    public function setIdHabitat($idHabitat)
    {
        $this->idHabitat = $idHabitat;
    }
}
