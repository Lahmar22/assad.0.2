<?php
require_once '../Models/user.php';

class Inscription
{
    public function inscription()
    {
        try {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $hash = password_hash($password, PASSWORD_DEFAULT);

            if ($role === 'guid') {
                $status = 'Désactiver';
            } else {
                $status = 'Activer';
            }

            $user = new User();
            $user->inscription($nom, $prenom, $email, $hash, $role, $status);

            header('Location: ../index.php');
            exit();
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'DB ERROR : ' . $e->getMessage();
            echo '</pre>';
            exit();
        }
    }
}

$inscription = new Inscription();
$inscription->inscription();