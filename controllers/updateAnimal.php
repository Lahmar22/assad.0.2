<?php

require_once '../Models/animal.php';

class UpdateAnimal
{
    public function updateAnimal()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {

            $animal = new Animal();
            $animal->setNomAnimal($_POST["nom"]);
            $animal->setEspece($_POST["espece"]);
            $animal->setAlimentation($_POST["alimentation"]);
            $animal->setImage($_POST["image"]);
            $animal->setPaysorigine($_POST["paysorigine"]);
            $animal->setDescriptioncourte($_POST["descriptioncourte"]);
            $animal->setIdHabitat($_POST["habitat"]);

            $idAnimal = $_POST["id"];

            $anml = new Animal();
            $anml->updateAnimal($animal, $idAnimal);


            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$controller = new UpdateAnimal();
$controller->updateAnimal();
