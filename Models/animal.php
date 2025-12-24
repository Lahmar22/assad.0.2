<?php
require_once 'database.php';

class Animal
{
    private $id;
    private $nomAnimal;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $descriptioncourte;
    private $idHabitat;


    public function __construct($id = null, $nomAnimal = null, $espece = null, $alimentation = null, $image = null, $paysorigine = null, $descriptioncourte = null, $idHabitat = null)
    {
        $this->id = $id;
        $this->nomAnimal = $nomAnimal;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->descriptioncourte = $descriptioncourte;
        $this->idHabitat= $idHabitat;
    }

    public function getAll()
    {
        $db = Database::connect();
        $allAnimal = "SELECT animaux.id, animaux.nomAnimal, animaux.espèce, animaux.alimentation, animaux.image, animaux.paysorigine, animaux.descriptioncourte, habitats.nomHabitat 
        FROM animaux INNER JOIN habitats ON animaux.id_habitat = habitats.id_habitat";
        $stmt = $db->prepare($allAnimal);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
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
