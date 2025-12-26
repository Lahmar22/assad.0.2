<?php 
require_once 'database.php';

class User{
    private $name;
    private $firstName;
    private $email;
    private $password;
    private $statut;

    public function __construct($name, $firstName, $email, $password, $statut){
       $this->name = $name;
       $this->firstName = $firstName;
       $this->email = $email;
       $this->password = $password;
       $this->statut = $statut;
       
    }

    public function getAllUser()
    {
        $db = Database::connect();
        $allUser = "SELECT id_user, nom, prenom, email, role, statuse FROM utilisateur";
        $stmt = $db->prepare($allUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function removeUser($id)
    {
        $delete_user = "DELETE FROM utilisateur WHERE id_user = :id";

        $db = Database::connect();
        $stmt = $db->prepare($delete_user);
        return $stmt->execute(['id' => $id]);
    }

    public function statisticUser()
    {
        $db = Database::connect();
        $allUser = "SELECT role, COUNT(*) AS total FROM utilisateur GROUP BY role";
        $stmt = $db->prepare($allUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name=$name;
    }
    
    public function getFirstName(){
        return $this->firstName;
    }
    public function setFirstName($firstName){
        $this->firstName=$firstName;
    }
    
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email=$email;
    }

    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password=$password;
    }
    
    public function getStatut(){
        return $this->statut;
    }
    public function setStatut($statut){
        $this->statut=$statut;
    }

}
?>