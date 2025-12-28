<?php
require_once '../Models/visiteGuid.php';

class RemoveVisiteGuid
{

    public function removeVisiteGuid()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $id = $_POST["id_visitGuid"];

            $visitesG = new VisitesGuides();
            $visitesG->removeVisitGuid($id);

            header("Location: ../Views/guid/visiteGuid.php?success=1");
            exit();
        } catch (PDOException $e) {

            echo "<pre>";
            echo "DB ERROR : " . $e->getMessage();
            echo "</pre>";
            exit();
        }
    }
}

$remove = new RemoveVisiteGuid();
$remove->removeVisiteGuid();
