<?php

require_once '../Models/visiteGuid.php';

class CreateVisitGuid
{
    public function ajoutervisitGuid()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $titre = $_POST["titre"];
            $dateheure = $_POST["dateheure"];
            $langue = $_POST["langue"];
            $capacite_max = $_POST["capacite_max"];
            $duree = $_POST["duree"];
            $prix = $_POST["prix"];

            $visitGuid = new VisitesGuides(
                $titre,
                $dateheure,
                $langue,
                $capacite_max,
                $duree,
                $prix
            );

            $adminVisitGuid = new VisitesGuides();
            $adminVisitGuid->addVisitGuid($visitGuid);


            header("Location: ../Views/guid/home.php?success=1");
            exit();
        } catch (PDOException $e) {
            echo "<pre>";
            echo "DB ERROR : " . $e->getMessage();
            echo "</pre>";
            exit();
        } catch (Exception $e) {

            error_log($e->getMessage());
            header("Location: ../Views/guid/home.php?error=form");
            exit();
        }
    }
}

$controller = new CreateVisitGuid();
$controller->ajoutervisitGuid();
