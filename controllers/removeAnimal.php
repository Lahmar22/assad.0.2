<?php
require_once '../Models/animal.php';

class RemoveAnimal
{

    public function removeAnimal()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        try {
            $id = $_POST["id"];

            $anml = new Animal();
            $anml->removeAnimal($id);

            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$remove = new RemoveAnimal();
$remove->removeAnimal();
