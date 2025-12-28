<?php

require_once '../Models/parcourVisite.php';

class CreateParcourVisite
{
    public function createParcourVisite()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $titreetape = $_POST['titreetape'];
            $descriptionetape = $_POST['descriptionetape'];
            $ordreetape = $_POST['ordreetape'];
            $id_visite = $_POST['id_visite'];

            $parcourVisite = new ParcourVisite(
                $titreetape,
                $descriptionetape,
                $ordreetape,
                $id_visite
               
            );

            $guidParcourVisite = new ParcourVisite();
            $guidParcourVisite->createEtapeVisite($parcourVisite);

            header('Location: ../Views/guid/home.php?success=1');
            exit();
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'DB ERROR : ' . $e->getMessage();
            echo '</pre>';
            exit();
        }
    }
}

$controller = new CreateParcourVisite();
$controller->createParcourVisite();
