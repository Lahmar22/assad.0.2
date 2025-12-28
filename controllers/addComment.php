<?php

require_once '../Models/commentaire.php';

class AddCommentaire
{
    public function addCommentaire()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        try {
            $id_visite = $_POST['id_visite'];
            $id_user = $_POST['id_user'];
            $note = $_POST['note'];
            $commentaire = $_POST['commentaire'];
            $dateCommentaire = date('Y/m/d');

            $commentaire = new Commentaire(
                $id_visite,
                $id_user,
                $note,
                $commentaire,
                $dateCommentaire
            );

            $comm = new Commentaire();
            $comm->addCommentaire($commentaire);

            header('Location: ../Views/visitor/home.php?success=1');
            exit();
        } catch (PDOException) {
            header('Location: ../Views/visitor/home.php?error=db');
            exit();
        } 
    }
}

$controller = new AddCommentaire();
$controller->addCommentaire();
