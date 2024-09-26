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
    // Récupérer tous les repas avec le nom du club
public function getAllRepas(): array
{
    $query = $this->db->query('
        SELECT repas.*, club.nom AS club_nom 
        FROM repas 
        JOIN club ON repas.adresse = club.id
    ');
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


    // Récupérer un repas par ID
    public function getRepasById($id): ?array
    {
        $query = $this->db->prepare('SELECT * FROM repas WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau repas
    public function ajouterRepas($nom, $adresse, $date, $participants, $plats, $chefDeRencontre): void
{
    $query = $this->db->prepare('INSERT INTO repas (nom, adresse, date, participants, plats, chef_de_rencontre) 
                                 VALUES (:nom, :adresse, :date, :participants, :plats, :chef_de_rencontre)');
    $query->bindParam(':nom', $nom);
    $query->bindParam(':adresse', $adresse);
    $query->bindParam(':date', $date);
    $query->bindParam(':participants', $participants);
    $query->bindParam(':plats', $plats);
    $query->bindParam(':chef_de_rencontre', $chefDeRencontre);
    $query->execute();
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



    // Supprimer un repas 
    public function supprimerRepas($id): void
{
    $query = $this->db->prepare('DELETE FROM repas WHERE id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
}


}
