<?php

/**
 * RepasModel
 */
class RepasModel
{
    private $db;
     
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() // méthode constructeur...pour se connecter à la base de données
    {
        try {
            //connexion à la base de données:
            $this->db = new PDO('mysql:host=mysql-iut.alwaysdata.net;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }
    // Récupérer tous les repas
    // Récupérer tous les repas avec le nom du club
    /**
     * getAllRepas
     *
     * @return array
     */
    public function getAllRepas(): array
    {
        // requête de récupération de TOUS les repas
        $query = $this->db->query('
            SELECT repas.*, club.nom AS club_nom 
            FROM repas 
            JOIN club ON repas.adresse = club.id
        ');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    // Récupérer un repas par ID depuis la base de données
    /**
     * getRepasById
     *
     * @param  mixed $id
     * @return array
     */
    public function getRepasById($id): ?array
    {
        // requête SQL pour récupérer un repas en fonction de l'ID
        $query = $this->db->prepare('SELECT * FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute(); // exécution de requête
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getTenrac(): ?array
    {
        $query = $this->db->prepare('SELECT * FROM tenrac');
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau repas    
    /**
     * ajouterRepas
     *
     * @param  mixed $nom
     * @param  mixed $adresse
     * @param  mixed $date
     * @param  mixed $participants
     * @param  mixed $plats
     * @param  mixed $chefDeRencontre
     * @return void
     */
    public function ajouterRepas($nom, $adresse, $date, $participants, $plats, $chefDeRencontre): void
    {
        // requête d'insertion de repas
        $query = $this->db->prepare('INSERT INTO repas (nom, adresse, date, participants, plats, chef_de_rencontre) 
                                 VALUES (:nom, :adresse, :date, :participants, :plats, :chef_de_rencontre)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':date', $date);
        $query->bindParam(':participants', $participants);
        $query->bindParam(':plats', $plats);
        $query->bindParam(':chef_de_rencontre', $chefDeRencontre);
        $query->execute(); // exécution de requête
    }

    public function modifierRepas($id, $nom, $adresse, $date, $participants, $plats, $chefDeRencontre): void
    {
        $query = $this->db->prepare('UPDATE repas SET nom = :nom, adresse = :adresse, date = :date, participants = :participants, plats = :plats, chef_de_rencontre = :chef_de_rencontre WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom); 
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':date', $date); 
        $query->bindParam(':participants', $participants);
        $query->bindParam(':plats', $plats);
        $query->bindParam(':chef_de_rencontre', $chefDeRencontre);
        $query->execute();
    }

    // Supprimer un repas dans la base de données
    /**
     * supprimerRepas
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerRepas($id): void
    {
        //  requête de suppression d'un repas dans la base de données
        $query = $this->db->prepare('DELETE FROM repas WHERE id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute(); // exécution de requête
    }
}
