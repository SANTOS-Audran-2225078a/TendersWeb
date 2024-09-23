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
}
