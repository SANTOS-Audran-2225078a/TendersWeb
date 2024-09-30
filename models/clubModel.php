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


    // Ajouter un nouveau club    
    /**
     * ajouterClub
     *
     * @param  mixed $nom
     * @param  mixed $adresse
     * @return void
     */
    public function ajouterClub($nom, $adresse): void
    {
        $query = $this->db->prepare('INSERT INTO club (nom, adresse) VALUES (:nom, :adresse)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute();
    }

    // Modifier un club existant    
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
        $query = $this->db->prepare('UPDATE club SET nom = :nom, adresse = :adresse WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':adresse', $adresse);
        $query->execute();
    }


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
    // Supprimer un club    
    /**
     * supprimerClub
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerClub($id): void
    {
        $query = $this->db->prepare('DELETE FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un club par son ID     
    /**
     * getClubById
     *
     * @param  mixed $id
     * @return mixed
     */
    public function getClubById($id): mixed 
    {
        $query = $this->db->prepare('SELECT * FROM club WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}