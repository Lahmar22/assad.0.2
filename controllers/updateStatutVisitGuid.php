<?php

require_once '../Models/visiteGuid.php';

class UpdateStatutVisitGuid
{
    public function updatestatut()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {

            $id = $_POST["id_visiteGuid"];
            $statut = $_POST["statut"];

            $visiteGuid = new VisitesGuides();
            $visiteGuid->updateStatutVisitGuid($statut, $id);


            header("Location: ../Views/guid/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/guid/home.php?error=db");
            exit();
        }
    }
}

$controller = new UpdateStatutVisitGuid();
$controller->updatestatut();
