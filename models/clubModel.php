<?php

/**
 * ClubModel
 */
class ClubModel
{
    private $db;
    
    /**
     * __construct 
     * 
     * @return void
     */
    public function __construct() // méthode constructeur
    {
        try {
            $this->db = new PDO('mysql:host=mysql-iut.alwaysdata.net;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }

    // Récupérer tous les clubs depuis la base de données     
    /**
     * getAllClubs
     *
     * @return array
     */
    public function getAllClubs(): array
    {
        $query = $this->db->query('SELECT * FROM club');
        return $query->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau associatif
    }


    // Ajouter un nouveau club dans la base de données    
    /**
     * ajouterClub
     *
     * @param  mixed $nom
     * @param  mixed $adresse
     * @return void
     */
    public function ajouterClub($nom, $adresse): void
    {
        // insertion du club dans la base de données
        $query = $this->db->prepare('INSERT INTO club (nom, adresse) VALUES (:nom, :adresse)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute(); // exécution de la requête
    }

    // Modifier un club existant dans la base de données   
    /**
     * modifierClub
     *
     * @param  mixed $id
     * @param  mixed $nom
     * @param  mixed $adresse
     * @return void
     */
    public function modifierClub($id, $nom, $adresse): void
    {
        // modifie le club dans la base de données
        $query = $this->db->prepare('UPDATE club SET nom = :nom, adresse = :adresse WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute();
    }

    
    /**
     * supprimerClubEtRelierTenracs
     *
     * @param  mixed $clubId
     * @return void
     */
    // suppression du club et relier les tenracs avec l'Ordre (dans la base de données)
    public function supprimerClubEtRelierTenracs($clubId): void
    {
        try {
            // Commence une transaction pour assurer la cohérence des données
            $this->db->beginTransaction();

            // Mettre à jour les tenracs pour les lier à l'ordre si le club est supprimé
            $updateQuery = $this->db->prepare('UPDATE tenrac SET club_id = NULL, ordre_id = 1 WHERE club_id = :club_id');
            $updateQuery->bindParam(':club_id', $clubId, PDO::PARAM_INT);
            $updateQuery->execute();

            // Supprimer le club
            $deleteQuery = $this->db->prepare('DELETE FROM club WHERE id = :id');
            $deleteQuery->bindParam(':id', $clubId, PDO::PARAM_INT);
            $deleteQuery->execute();

            // Commit la transaction
            $this->db->commit();
        } catch (PDOException $e) {
            // Annuler la transaction en cas d'erreur
            $this->db->rollBack();
            echo 'Erreur lors de la suppression du club : ' . $e->getMessage();
        }
    }
    // Supprimer un club dans la base de données   
    /**
     * supprimerClub
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerClub($id): void
    {
        // requête de suppression d'un club
        $query = $this->db->prepare('DELETE FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute(); // exécution de la requête
    }

    // Récupérer un club par son ID depuis la base de données    
    /**
     * getClubById
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getClubById($id): mixed 
    {
        // requête de récupération par ID du club
        $query = $this->db->prepare('SELECT * FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute(); // exécution de la requête
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}