<?php

require_once '../Models/habitat.php';

class UpdateHabitat
{
    public function updateHabitat()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {

            $habitat = new Habitat();
            $habitat->setNomHabitat($_POST["nomhabitat"]);
            $habitat->setTypeclimat($_POST["typeclimat"]);
            $habitat->setDescription($_POST["description"]);
            $habitat->setzonezoo($_POST["zonezoo"]);
            

            $id = $_POST["id"];

            $hab = new Habitat();
            $hab->updateHabitat($habitat, $id);


            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$controller = new UpdateHabitat();
$controller->updateHabitat();
