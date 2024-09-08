<?php

class tenracModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=mysql-iut.alwaysdata.net;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }

    // Récupérer tous les tenracs
    public function getAllTenracs()
    {
        $query = $this->db->prepare('SELECT * FROM tenrac');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // voir un tenrac spécifique
    public function getTenracById($id)
{
    $query = $this->db->prepare('SELECT * FROM tenrac WHERE id = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}


    // Ajouter un nouveau tenrac
    public function addTenrac($nom, $email, $tel, $adresse, $grade, $ordre_id, $club_id)
    {
        $query = $this->db->prepare('INSERT INTO tenrac (nom, email, tel, adresse, grade, ordre_id, club_id) VALUES (:nom, :email, :tel, :adresse, :grade, :ordre_id, :club_id)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':email', $email);
        $query->bindParam(':tel', $tel);
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':grade', $grade);
        $query->bindParam(':ordre_id', $ordre_id);
        $query->bindParam(':club_id', $club_id);
        return $query->execute();
    }

    // Modifier un tenrac existant
    public function updateTenrac($id, $nom, $email, $tel, $adresse, $grade, $ordre_id, $club_id)
    {
        $query = $this->db->prepare('UPDATE tenrac SET nom = :nom, email = :email, tel = :tel, adresse = :adresse, grade = :grade, ordre_id = :ordre_id, club_id = :club_id WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':email', $email);
        $query->bindParam(':tel', $tel);
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':grade', $grade);
        $query->bindParam(':ordre_id', $ordre_id);
        $query->bindParam(':club_id', $club_id);
        return $query->execute();
    }

    // Supprimer un tenrac
    public function deleteTenrac($id)
    {
        $query = $this->db->prepare('DELETE FROM tenrac WHERE id = :id');
        $query->bindParam(':id', $id);
        return $query->execute();
    }

}
