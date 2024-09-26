<?php

class TenracModel
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

    // Méthode pour vérifier les identifiants du tenrac
    public function verifierTenrac($nom, $motDePasse): ?array
    {
        $query = $this->db->prepare('SELECT * FROM tenrac WHERE nom = :nom AND password = :password');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':password', $motDePasse); // Assure-toi d'utiliser une méthode de hachage pour le mot de passe
        $query->execute();

        $tenrac = $query->fetch(PDO::FETCH_ASSOC);

        if ($tenrac) {
            return $tenrac;
        } else {
            return null; // Retourne null si aucune correspondance n'est trouvée
        }
    } 

    // Récupérer tous les tenracs (utilisé pour l'affichage des adresses dans la gestion des repas)
    public function getAllTenracs(): array
    {
        $query = $this->db->query('SELECT * FROM tenrac');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau tenrac
    public function ajouterTenrac($data): void
    {
        $query = $this->db->prepare('INSERT INTO tenrac (nom, adresse, email, password, tel, club_id, ordre_id) 
                                     VALUES (:nom, :adresse, :email, :password, :tel, :club_id, :ordre_id)');
        $query->execute([
            ':nom' => $data['nom'],
            ':adresse' => $data['adresse'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':tel' => $data['tel'],
            ':club_id' => $data['club_id'],
            ':ordre_id' => $data['ordre_id']
        ]);
    }

    // Modifier un tenrac existant
    public function modifierTenrac($id, $data): void
    {
        $query = $this->db->prepare('UPDATE tenrac SET nom = :nom, adresse = :adresse, email = :email, password = :password, 
                                      tel = :tel, club_id = :club_id, ordre_id = :ordre_id WHERE id = :id');
        $query->execute([
            ':id' => $id,
            ':nom' => $data['nom'],
            ':adresse' => $data['adresse'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':tel' => $data['tel'],
            ':club_id' => $data['club_id'],
            ':ordre_id' => $data['ordre_id']
        ]);
    }

    public function supprimerTenrac($id): void
{
    $query = $this->db->prepare('DELETE FROM tenrac WHERE id = :id');
    $query->bindParam(':id', $id);
    $query->execute();
}

public function getTenracById(int $id): ?array
{
    $query = $this->db->prepare('SELECT * FROM tenrac WHERE id = :id');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $tenrac = $query->fetch(PDO::FETCH_ASSOC);

    return $tenrac ?: null;
}



}
 