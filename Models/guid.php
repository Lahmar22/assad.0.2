<?php 
class Guid extends User
{ 
    private $role;
    public function __construct($name, $firstName, $email, $password, $statut, $role)
    {
        parent::__construct($name, $firstName, $email, $password, $statut);
        $this->role = $role;

    }



}
?>