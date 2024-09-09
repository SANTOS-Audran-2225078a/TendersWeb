<?php

class PlatModel
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

    // Récupérer tous les plats
    public function getAllPlats()
    {
        $query = $this->db->query('SELECT * FROM plat');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau plat
    public function ajouterPlat($nom, $ingredients, $aliment_a_risque, $club_id)
    {
        $query = $this->db->prepare('INSERT INTO plat (nom, ingredients, aliment_a_risque, club_id) VALUES (:nom, :ingredients, :aliment_a_risque, :club_id)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':ingredients', $ingredients);
        $query->bindParam(':aliment_a_risque', $aliment_a_risque);
        $query->bindParam(':club_id', $club_id);
        $query->execute();
    }

    // Modifier un plat existant
    public function modifierPlat($id, $nom, $ingredients, $aliment_a_risque, $club_id)
    {
        $query = $this->db->prepare('UPDATE plat SET nom = :nom, ingredients = :ingredients, aliment_a_risque = :aliment_a_risque, club_id = :club_id WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':ingredients', $ingredients);
        $query->bindParam(':aliment_a_risque', $aliment_a_risque);
        $query->bindParam(':club_id', $club_id);
        $query->execute();
    }

    // Supprimer un plat
    public function supprimerPlat($id)
    {
        $query = $this->db->prepare('DELETE FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un plat par son ID
    public function getPlatById($id)
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les plats par club
    public function getPlatsByClub($club_id)
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE club_id = :club_id');
        $query->bindParam(':club_id', $club_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
