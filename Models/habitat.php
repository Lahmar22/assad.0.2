<?php 
class Habitat{
    private $id_habitat;
    private $nomHabitat;
    private $typeclimat;
    private $description;
    private $zonezoo;

    
    public function __construct($id_habitat = null, $nomHabitat = null, $typeclimat = null, $description = null, $zonezoo = null)
    {
        $this->id_habitat=$id_habitat;
        $this->nomHabitat=$nomHabitat;
        $this->typeclimat=$typeclimat;
        $this->description=$description;
        $this->zonezoo=$zonezoo;
       
    }


    public function getId_habitat(){
        return $this->id_habitat;
    }
    public function setId_habitat($id_habitat){
        $this->id_habitat = $id_habitat;
    }

    public function getNomHabitat(){
        return $this->nomHabitat;
    }
    public function setNomHabitat($nomHabitat){
        $this->nomHabitat = $nomHabitat;
    }

    public function getTypeclimat(){
        return $this->typeclimat;
    }
    public function setTypeclimat($typeclimat){
        $this->typeclimat = $typeclimat;
    }

    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }

    public function getZonezoo(){
        return $this->zonezoo;
    }
    public function setImage($zonezoo){
        $this->zonezoo = $zonezoo;
    }

    
}
?>