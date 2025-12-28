<?php
require_once 'database.php';

class Habitat
{
    private $nomHabitat;
    private $typeclimat;
    private $description;
    private $zonezoo;


    public function __construct($nomHabitat = null, $typeclimat = null, $description = null, $zonezoo = null)
    {
        $this->nomHabitat = $nomHabitat;
        $this->typeclimat = $typeclimat;
        $this->description = $description;
        $this->zonezoo = $zonezoo;
    }

    public function getAllHabitat()
    {
        $db = Database::connect();
        $allHabitat = "SELECT id_habitat, nomHabitat, typeclimat, description, zonezoo FROM habitats";
        $stmt = $db->prepare($allHabitat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectNomHabitat() {
        $db = Database::connect();
        $sqlNomHabitat = "SELECT nomHabitat FROM habitats";
        $stmt = $db->prepare($sqlNomHabitat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }

    public function addHabitat(Habitat $habitat)
    {
        $Add_habitat = "INSERT INTO habitats(nomHabitat, typeclimat, description, zonezoo) VALUES(?, ?, ?, ?)";

        $db = Database::connect();
        $stmt = $db->prepare($Add_habitat);
        return $stmt->execute([
            $habitat->getNomHabitat(),
            $habitat->getTypeclimat(),
            $habitat->getDescription(),
            $habitat->getZonezoo()

        ]);
    }

    public function updateHabitat(Habitat $habitat , $id)
    {
        $sqlupdateHab = "UPDATE habitats SET nomHabitat = :nomhabitat, typeclimat = :typeclimat, description = :description, zonezoo = :zonezoo
            WHERE id_habitat = :id";

        $db = Database::connect();
        $stmt = $db->prepare($sqlupdateHab);

        return $stmt->execute([
            'nomhabitat'  => $habitat->getNomHabitat(),
            'typeclimat' => $habitat->getTypeClimat(),
            'description' => $habitat->getDescription(),
            'zonezoo'    => $habitat->getZoneZoo(),
            'id'         => $id
        ]);
    }


    public function removeHabitat($id)
    {
        $Add_habitat = "DELETE FROM habitats WHERE id_habitat = :id";

        $db = Database::connect();
        $stmt = $db->prepare($Add_habitat);
        return $stmt->execute(['id' => $id]);
    }


    public function getNomHabitat()
    {
        return $this->nomHabitat;
    }
    public function setNomHabitat($nomHabitat)
    {
        $this->nomHabitat = $nomHabitat;
    }

    public function getTypeclimat()
    {
        return $this->typeclimat;
    }
    public function setTypeclimat($typeclimat)
    {
        $this->typeclimat = $typeclimat;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getZonezoo()
    {
        return $this->zonezoo;
    }
    public function setzonezoo($zonezoo)
    {
        $this->zonezoo = $zonezoo;
    }
}
