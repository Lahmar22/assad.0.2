<?php 
require_once 'reservations.php';
require_once 'database.php';

class Visitor extends User
{ 
    private $role;
    public function __construct($name, $firstName, $email, $password, $statut, $role)
    {
        parent::__construct($name, $firstName, $email, $password, $statut);
        $this->role = $role;

    }

    public function reserveVisitGuid(Reservation $reservation){
        $reserveVisite = "INSERT INTO reservations (idvisite, idutilisateur, nbpersonnes, datereservation) VALUES(?, ?, ?, ?)";

        $db = Database::connect();
        $stmt = $db->prepare($reserveVisite);
        return $stmt->execute([
            $reservation->getIdVisiteGuid(),
            $reservation->getIdUser(),
            $reservation->getNbrPersonne(),
            $reservation->getDateReservation()
           
        ]);

    }

    public function getRole(){
        return $this->role;
    }

    public function setRole($role){
        $this->role = $role;
    }



}
?>