<?php
class VisitesGuides
{

    private $id;
    private $titre;
    private $dateheure;
    private $langue;
    private $capacite_max;
    private $statut;
    private $duree;
    private $prix;  

    public function __construct($id, $titre, $dateheure, $langue, $capacite_max, $statut, $duree, $prix)
    {
        $this->id= $id;
        $this->titre= $titre;
        $this->dateheure= $dateheure;
        $this->langue= $langue;
        $this->capacite_max= $capacite_max;
        $this->id= $id;
        $this->id= $id;
        $this->id= $id;
        $this->id= $id;
        

    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDateheure()
    {
        return $this->dateheure;
    }

    public function getLangue()
    {
        return $this->langue;
    }

    public function getCapaciteMax()
    {
        return $this->capacite_max;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function getDuree()
    {
        return $this->duree;
    }

    public function getPrix()
    {
        return $this->prix;
    }


    public function setId($id)
    {
        $this->id = $id;
    
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setDateheure($dateheure)
    {
        $this->dateheure = $dateheure;

    }

    public function setLangue($langue)
    {
        $this->langue = $langue;
    }

    public function setCapaciteMax($capacite_max)
    {
        $this->capacite_max = $capacite_max;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
}
