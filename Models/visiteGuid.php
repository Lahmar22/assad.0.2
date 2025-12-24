<?php
require_once 'database.php';
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

    public function __construct($id = null, $titre = null, $dateheure = null, $langue = null, $capacite_max = null, $statut = null, $duree = null, $prix = null)
    {
        $this->id= $id;
        $this->titre= $titre;
        $this->dateheure= $dateheure;
        $this->langue= $langue;
        $this->capacite_max= $capacite_max;
        $this->statut= $statut;
        $this->duree= $duree;
        $this->prix= $prix;

    }

    public function getAllVisitesGuides()
    {
        $db = Database::connect();
        $allVisiteGuides = "SELECT id, titre, dateheure, langue, capacite_max, statut, duree, prix FROM visitesguidees";
        $stmt = $db->prepare($allVisiteGuides);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
