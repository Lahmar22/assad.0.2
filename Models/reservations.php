<?php 
require_once 'database.php';
class Reservation
{
    private $id_reserve;
    private $id_visiteGuid;
    private $id_user;
    private $nbrPersonne;
    private $dateReservation;

    public function __construct($id_reserve = null, $id_visiteGuid = null, $id_user = null, $nbrPersonne = null, $dateReservation = null) {
        $this->id_reserve = $id_reserve;
        $this->id_visiteGuid = $id_visiteGuid;
        $this->id_user = $id_user;
        $this->nbrPersonne = $nbrPersonne;
        $this->dateReservation = $dateReservation;
    }

    public function getAllReservation($id_utilisateur)
    {
        $db = Database::connect();
        $allReservation = "SELECT r.id, r.idvisite, r.idutilisateur, r.nbpersonnes, r.datereservation, v.id AS visite_id, v.titre, 
        DATE(v.dateheure) AS dateVG, TIME(v.dateheure) AS timeVG, v.statut, v.duree, v.prix, u.id_user, u.nom, u.prenom FROM reservations r 
        INNER JOIN visitesguidees v ON r.idvisite = v.id INNER JOIN utilisateur u ON r.idutilisateur = u.id_user WHERE r.idutilisateur = $id_utilisateur ";
        $stmt = $db->prepare($allReservation);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getIdReserve()
    {
        return $this->id_reserve;
    }

    public function setIdReserve($id_reserve)
    {
        $this->id_reserve = $id_reserve;
    }

    public function getIdVisiteGuid()
    {
        return $this->id_visiteGuid;
    }

    public function setIdVisiteGuid($id_visiteGuid)
    {
        $this->id_visiteGuid = $id_visiteGuid;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getNbrPersonne()
    {
        return $this->nbrPersonne;
    }

    public function setNbrPersonne($nbrPersonne)
    {
        $this->nbrPersonne = $nbrPersonne;
    }

    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;
    }
}

?>