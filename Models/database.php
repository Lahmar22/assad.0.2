<?php 
class Database {

    public static function connect() {
        try {

            $conn = new PDO("mysql:host=localhost;dbname=assadV2;charset=utf8mb4", "root", "");
            

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn; 
            
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>