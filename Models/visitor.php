<?php 
require_once 'visitrGuid.php';
require_once 'database.php';

class Visitor extends User
{ 
    private $role;
    public function __construct($name, $firstName, $email, $password, $statut, $role)
    {
        parent::__construct($name, $firstName, $email, $password, $statut);
        $this->role = $role;

    }

    public function reserveVisitGuid(VisitesGuides $visitesGuides){
        $reserveVisite = "INSERT INTO visitesguidees (titre, dateheure, langue, capacite_max, statut, duree, prix)
        VALUES(?, ?, ?, ?, ?, ?, ? )";

        $db = Database::connect();
        $stmt = $db->prepare($reserveVisite);
        return $stmt->execute([
            $visitesGuides->getTitre(),
            $visitesGuides->getDateheure(),
            $visitesGuides->getLangue(),
            $visitesGuides->getCapaciteMax(),
            $visitesGuides->getStatut(),
            $visitesGuides->getDuree(),
            $visitesGuides->getPrix()
        ]);

    }



}
?>