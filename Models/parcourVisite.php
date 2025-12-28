<?php
require_once 'database.php';
class ParcourVisite
{
    private $titreetape;
    private $descriptionetape;
    private $ordreetape;
    private $id_visite;

    public function __construct($titreetape = null, $descriptionetape = null, $ordreetape = null, $id_visite = null){  
        $this->titreetape = $titreetape;
        $this->descriptionetape = $descriptionetape;
        $this->ordreetape = $ordreetape;
        $this->id_visite = $id_visite;
    }

    public function createEtapeVisite(ParcourVisite $parcour_visite){
        $db = Database::connect();
        $sqlEtapeVisite = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sqlEtapeVisite);

        return $stmt->execute([
            $parcour_visite->getTitreetape(),
            $parcour_visite->getDescriptionetape(),
            $parcour_visite->getOrdreetape(),
            $parcour_visite->getIdVisite()           
        ]);


    }

    public function getTitreetape(){    
        return $this->titreetape;
    }
    public function getDescriptionetape(){
        return $this->descriptionetape;
    }

    public function getOrdreetape(){
        return $this->ordreetape;
    }
    public function getIdVisite(){
        return $this->id_visite;
    }
    public function setTitreetape($titreetape){
        $this->titreetape = $titreetape;
    }
    public function setDescriptionetape($descriptionetape){
        $this->descriptionetape = $descriptionetape;
    }
    public function setOrdreetape($ordreetape){
        $this->ordreetape = $ordreetape;
    }
    public function setIdVisite($id_visite){
        $this->id_visite = $id_visite;
    }

}

