<?php
require_once '../Models/visiteGuid.php';
require_once '../Models/reservations.php';

class AnnulerReservation
{

    public function annulerReser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        try {
            $id = $_POST["id"];
            $idvisite = $_POST["idvisite"];
            $nbrPersonne = $_POST["nbrPersonne"];

            $reser = new Reservations();
            $reser->annulerReservation($id);

            $visitGuid = new VisitesGuides();
            $visitGuid->updateCapaciteVisiteGuidAnnuler($nbrPersonne, $idvisite);

            header("Location: ../Views/visitor/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/visitor/home.php?error=db");
            exit();
        }
    }
}

$annuler = new AnnulerReservation();
$annuler->annulerReser();
