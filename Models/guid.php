<?php 
require_once 'visitrGuid.php';
require_once 'database.php';

class Guid extends User
{ 
    private $role;
    private $statut;
    public function __construct($name, $firstName, $email, $password, $role, $statut)
    {
        parent::__construct($name, $firstName, $email, $password);
        $this->role = $role;
        $this->statut = $statut;

    }

    

    public function getRole(){ 
        return $this->role;
    }
    public function setRole($role){
        $this->role = $role;
    }
    public function getStatut(){
        return $this->statut;
    }
    
    public function setStatut($statut){
        $this->statut = $statut;
    }



}
?>