<?php

class Logout
{

    public function logout()
    {
        session_start();

        session_unset();

        session_destroy();

        header("Location: ../index.php");
        exit();
    }
}

$logout = new Logout();
$logout->logout();
