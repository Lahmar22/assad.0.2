<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../Models/animal.php';
require_once '../Models/database.php';

class AjouterAnimal
{
    public function ajouterAnimal()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $nom = trim($_POST["nom"]);
            $espece = trim($_POST["espece"]);
            $alimentation = trim($_POST["alimentation"]);
            $paysorigine = trim($_POST["paysorigine"]);
            $description = trim($_POST["descriptioncourte"]);
            $habitat = (int) $_POST["habitat"];
            $image = trim($_POST["image"]);

            $animal = new Animal(
                $nom,
                $espece,
                $alimentation,
                $image,
                $paysorigine,
                $description,
                $habitat
            );

            $adminAnimal = new Animal();
            $adminAnimal->addAnimal($animal);


            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException $e) {
            echo "<pre>";
            echo "DB ERROR : " . $e->getMessage();
            echo "</pre>";
            exit();
        } catch (Exception $e) {

            error_log($e->getMessage());
            header("Location: ../Views/admin/home.php?error=form");
            exit();
        }
    }
}

$controller = new AjouterAnimal();
$controller->ajouterAnimal();
