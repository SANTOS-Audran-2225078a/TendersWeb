<?php

class ClubModel
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

    // Récupérer tous les clubs
    public function getAllClubs()
    {
        $query = $this->db->query('SELECT * FROM club');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau club
    public function ajouterClub($nom, $adresse)
    {
        $query = $this->db->prepare('INSERT INTO club (nom, adresse) VALUES (:nom, :adresse)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute();
    }

    // Modifier un club existant
    public function modifierClub($id, $nom, $adresse)
    {
        $query = $this->db->prepare('UPDATE club SET nom = :nom, adresse = :adresse WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute();
    }

    // Supprimer un club
    public function supprimerClub($id)
    {
        $query = $this->db->prepare('DELETE FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un club par son ID
    public function getClubById($id)
    {
        $query = $this->db->prepare('SELECT * FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
