<?php

class RepasModel
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

    // Récupérer tous les repas
    public function getAllRepas()
    {
        $query = $this->db->query('SELECT * FROM repas');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau repas
    public function ajouterRepas($nom, $date, $lieu)
    {
        $query = $this->db->prepare('INSERT INTO repas (nom, date, lieu) VALUES (:nom, :date, :lieu)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':date', $date);
        $query->bindParam(':lieu', $lieu);
        $query->execute();
    }

    // Modifier un repas existant
    public function modifierRepas($id, $nom, $date, $lieu)
    {
        $query = $this->db->prepare('UPDATE repas SET nom = :nom, date = :date, lieu = :lieu WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':date', $date);
        $query->bindParam(':lieu', $lieu);
        $query->execute();
    }

    // Supprimer un repas
    public function supprimerRepas($id)
    {
        $query = $this->db->prepare('DELETE FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un repas par son ID
    public function getRepasById($id)
    {
        $query = $this->db->prepare('SELECT * FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
