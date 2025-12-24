<?php
session_start();
require_once '../Models/login.php';

class LoginController
{
    public function verifierLogin()
    {
        if (!isset($_POST['email'], $_POST['password'])) {
            header("Location: ../index.php?error=missing_fields");
            exit();
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $login = new Login();
        $user = $login->login($email);

        if (!$user) {
            header("Location: ../index.php?error=email_not_found");
            exit();
        }

        if (!password_verify($password, $user->password)) {
            header("Location: ../index.php?error=wrong_password");
            exit();
        }

        $_SESSION['email'] = $user->email;
        $_SESSION['nom'] = $user->nom;
        $_SESSION['prenom'] = $user->prenom;
        $_SESSION['role'] = $user->role;

        if ($user->role === 'admin') {
            $_SESSION['id_admin'] = $user->id_admin;
            header("Location: ../Views/admin/home.php");
            exit();
        }

        $_SESSION['id_user'] = $user->id_user; 

        if ($user->statuse === 'Désactiver') {
            header("Location: ../Views/attente.php");
            exit();
        }

        if ($user->role === 'visiteur') {
            header("Location: ../Views/visitor/home.php");
        } elseif ($user->role === 'guid') {
            header("Location: ../Views/guid/home.php");
        } else {
            header("Location: ../index.php?error=unknown_role");
        }

        exit();
    }
}

$log = new LoginController();
$log->verifierLogin();

?>
