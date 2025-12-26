<?php
require_once 'database.php';
class VisitesGuides
{
    private $titre;
    private $dateheure;
    private $langue;
    private $capacite_max;
    private $statut;
    private $duree;
    private $prix;

    public function __construct($titre = null, $dateheure = null, $langue = null, $capacite_max = null, $statut = null, $duree = null, $prix = null)
    {
        $this->titre = $titre;
        $this->dateheure = $dateheure;
        $this->langue = $langue;
        $this->capacite_max = $capacite_max;
        $this->statut = $statut;
        $this->duree = $duree;
        $this->prix = $prix;
    }

    public function addVisitGuid(VisitesGuides $visitesGuide)
    {

        $sqlVisiteGuid = "INSERT INTO visitesguidees(titre, dateheure, langue, capacite_max, duree, prix) VALUES(?, ?, ?, ?, ?, ?)";

        $db = Database::connect();
        $stmt = $db->prepare($sqlVisiteGuid);

        return $stmt->execute([
            $visitesGuide->getTitre(),
            $visitesGuide->getDateheure(),
            $visitesGuide->getLangue(),
            $visitesGuide->getCapaciteMax(),
            $visitesGuide->getDuree(),
            $visitesGuide->getPrix()
        ]);
    }

    public function removeVisitGuid($id)
    {
        $db = Database::connect();
        $delete_visitGuid = "DELETE FROM visitesguidees WHERE id = :id";

        $stmt = $db->prepare($delete_visitGuid);
        return $stmt->execute(['id' => $id]);
    }

    public function getAllVisitesGuides()
    {
        $db = Database::connect();
        $allVisiteGuides = "SELECT id, titre, dateheure, langue, capacite_max, statut, duree, prix FROM visitesguidees";
        $stmt = $db->prepare($allVisiteGuides);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getVisitesGuidesRecherche($cherche)
    {
        $db = Database::connect();
        $allVisiteGuides = "SELECT id, titre, dateheure, langue, capacite_max, statut, duree, prix FROM visitesguidees WHERE titre = :cherche";
        $stmt = $db->prepare($allVisiteGuides);
        $stmt->execute(['cherche' => $cherche]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    public function updateStatutVisitGuid($status, $id)
    {
        $db = Database::connect();
        $sqlUpdateStatut = "UPDATE visitesguidees SET statut = :status WHERE id = :id";
        $stmt = $db->prepare($sqlUpdateStatut);
        return $stmt->execute(['id'  => $id, 'status' => $status]);
    }

    public function updateCapaciteVisiteGuidResever($nbr, $id)
    {
        $db = Database::connect();
        $sqlUpdateStatut = "UPDATE visitesguidees SET capacite_max = capacite_max - :nbr WHERE id = :id";
        $stmt = $db->prepare($sqlUpdateStatut);
        return $stmt->execute(['nbr'  => $nbr, 'id' => $id]);
    }

    public function updateCapaciteVisiteGuidAnnuler($nbr, $id)
    {
        $db = Database::connect();
        $sqlUpdateStatut = "UPDATE visitesguidees SET capacite_max = capacite_max + :nbr WHERE id = :id";
        $stmt = $db->prepare($sqlUpdateStatut);
        return $stmt->execute(['nbr'  => $nbr, 'id' => $id]);
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
