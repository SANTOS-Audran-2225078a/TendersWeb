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
    /**
     * getAllRepas
     *
     * @return void
     */
    public function getAllRepas()
    {
        $query = $this->db->query('SELECT * FROM repas');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau repas    
    /**
     * ajouterRepas
     *
     * @param  mixed $adresse
     * @param  mixed $date
     * @param  mixed $participants
     * @param  mixed $plats
     * @return void
     */
    public function ajouterRepas($adresse, $date, $participants, $plats)
    {
        $query = $this->db->prepare('INSERT INTO repas (adresse, date, participants, plats) VALUES (:adresse, :date, :participants, :plats)');
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':date', $date);
        $query->bindParam(':participants', $participants);
        $query->bindParam(':plats', $plats);
        $query->execute();
    }

    // Modifier un repas existant    
    /**
     * modifierRepas
     *
     * @param  mixed $id
     * @param  mixed $adresse
     * @param  mixed $date
     * @param  mixed $participants
     * @param  mixed $plats
     * @return void
     */
    public function modifierRepas($id, $adresse, $date, $participants, $plats)
    {
        $query = $this->db->prepare('UPDATE repas SET adresse = :adresse, date = :date, participants = :participants, plats = :plats WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':adresse', $adresse);
        $query->bindParam(':date', $date);
        $query->bindParam(':participants', $participants);
        $query->bindParam(':plats', $plats);
        $query->execute();
    }

    // Supprimer un repas    
    /**
     * supprimerRepas
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerRepas($id)
    {
        $query = $this->db->prepare('DELETE FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un repas par son ID    
    /**
     * getRepasById
     *
     * @param  mixed $id
     * @return void
     */
    public function getRepasById($id)
    {
        $query = $this->db->prepare('SELECT * FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * getRepasImportant
     *
     * @return void
     */
    public function getRepasImportant()
{
    $query = $this->db->query('SELECT * FROM repas WHERE date >= CURDATE() ORDER BY date ASC LIMIT 5');
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

}