<?php
require_once 'database.php';
class Login
{

    public function login($email)
    {
        $db = Database::connect();

        $sqlAdmin = "SELECT id_admin, nom, prenom, email, password, 'admin' AS role
                 FROM admin
                 WHERE email = :email ";

        $stmt = $db->prepare($sqlAdmin);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_OBJ);

        if ($admin) {
            return $admin;
        }

        $sqlUser = "SELECT id_user, nom, prenom, email, password, role, statuse
                FROM utilisateur
                WHERE email = :email";

        $stmt = $db->prepare($sqlUser);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        return $user ?: null;
    }
}
