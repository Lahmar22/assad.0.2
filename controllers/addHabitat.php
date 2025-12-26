<?php

require_once '../Models/habitat.php';
require_once '../Models/admin.php';

class AddHabitat
{
    public function ajouterHabitat()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $nomhabitat = $_POST["nomhabitat"];
            $typeclimat = $_POST["typeclimat"];
            $description = $_POST["description"];
            $zonezoo = $_POST["zonezoo"];


            $habitat = new Habitat(
                $nomhabitat,
                $typeclimat,
                $description,
                $zonezoo
            );

            $hab = new Habitat();
            $hab->addHabitat($habitat);


            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
             header("Location: ../Views/admin/home.php?error=db");
            exit();
        } catch (Exception $e) {

            error_log($e->getMessage());
            header("Location: ../Views/admin/home.php?error=form");
            exit();
        }
    }
}

$controller = new AddHabitat();
$controller->ajouterHabitat();
