<?php
require_once '../Models/habitat.php';

class RemoveHabitat
{

    public function removeHab()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        try {
            $id = $_POST["id"];

            $hab = new Habitat();
            $hab->removeHabitat($id);

            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$remove = new RemoveHabitat();
$remove->removeHab();
