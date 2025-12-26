<?php
require_once '../Models/admin.php';

class RemoveUser
{

    public function removeUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        try {
            $id = $_POST["id"];

            $usr = new Admin();
            $usr->removeUser($id);

            header("Location: ../Views/admin/home.php?success=1");
            exit();
        } catch (PDOException) {
            header("Location: ../Views/admin/home.php?error=db");
            exit();
        }
    }
}

$remove = new RemoveUser();
$remove->removeUser();
