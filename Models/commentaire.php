<?php
require_once 'database.php';
class Commentaire
{
    private $idvisitesguides;
    private $idutilisateur;
    private $note;
    private $texte;
    private $date_commentaire;

    public function __construct($idvisitesguides = null, $idutilisateur = null, $note = null, $texte = null, $date_commentaire = null) {
        $this->idvisitesguides = $idvisitesguides;
        $this->idutilisateur = $idutilisateur;
        $this->note = $note;
        $this->texte = $texte;
        $this->date_commentaire = $date_commentaire;

    }

    public function addCommentaire(Commentaire $commentaire) {

        $sqlCommentaire = "INSERT INTO commentaires(idvisitesguides, idutilisateur, note, texte, date_commentaire) VALUES(?, ?, ?, ?, ?)";
        $db = Database::connect();
        $stmt = $db->prepare($sqlCommentaire);

        return $stmt->execute([
            $commentaire->getIdvisitesguides(),
            $commentaire->getIdutilisateur(),
            $commentaire->getNote(),
            $commentaire->getTexte(),
            $commentaire->getDatecommentaire()
        ]);
    }

    public function getIdvisitesguides() {
        return $this->idvisitesguides;
    }
    public function setIdvisitesguides($idvisitesguides) {
        $this->idvisitesguides = $idvisitesguides;
    }
    public function getIdutilisateur() {
        return $this->idutilisateur;

    }
    public function setIdutilisateur($idutilisateur) {
        $this->idutilisateur = $idutilisateur;
    }
    public function getNote() {
        return $this->note;

    }
    public function setNote($note) {
        $this->note = $note;
    }
    public function getTexte() {
        return $this->texte;
    }
    public function setTexte($texte) {
        $this->texte = $texte;
    }
    public function getDatecommentaire() {
        return $this->date_commentaire;
    }
    public function setDatecommentaire($date_commentaire) {
        $this->date_commentaire = $date_commentaire;
    }

}
