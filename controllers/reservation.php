<?php

require_once '../Models/reservations.php';
require_once '../Models/visiteGuid.php';

class Reservation
{
    public function reservationVisitGuid()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            
            $id_visiteGuid = $_POST["id_visiteGuid"];
            $id_user = $_POST["id_user"];
            $nbpersonnes = $_POST["nbpersonnes"];
            $datereservation = date("Y/m/d");


            $reservation = new Reservations(
                $id_visiteGuid,
                $id_user,
                $nbpersonnes,
                $datereservation
            );

            $resv = new Reservations();
            $resv->reservationVisiteGuid($reservation);
            $visitGuid = new VisitesGuides();
            $visitGuid->updateCapaciteVisiteGuidResever($nbpersonnes, $id_visiteGuid);



            header("Location: ../Views/visitor/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/visitor/home.php?error=db");
            exit();
        }
    }
}

$controller = new Reservation();
$controller->reservationVisitGuid();
