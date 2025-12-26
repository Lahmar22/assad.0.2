<?php

require_once '../Models/admin.php';

class UpdateStatut
{
    public function updatestatut()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {

            $status = $_POST["statuse"];
            $id = $_POST["id_user"];

            $admin = new admin();
            $admin->updateStatut($status, $id);


            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$controller = new UpdateStatut();
$controller->updatestatut();
