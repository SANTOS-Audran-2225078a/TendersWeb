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
    public function ajouterPlat($nom, $description)
    {
        $query = $this->db->prepare('INSERT INTO plat (nom, description) VALUES (:nom, :description)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':description', $description);
        $query->execute();
    }

    // Modifier un plat existant
    public function modifierPlat($id, $nom, $description)
    {
        $query = $this->db->prepare('UPDATE plat SET nom = :nom, description = :description WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':description', $description);
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
}
