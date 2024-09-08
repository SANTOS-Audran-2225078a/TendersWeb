<?php

class tenracModel
{
    private $db;

    public function __construct()
    {
        // Connexion à la base de données (par exemple via PDO)
        $this->db = new PDO('mysql:host=localhost;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.');
    }

    public function verifierTenrac($id, $motDePasse)
    {
        $query = $this->db->prepare('SELECT * FROM tenrac WHERE id = :id AND password = :password');
        $query->bindParam(':id', $id);
        $query->bindParam(':password', $motDePasse); // Liaison du mot de passe
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC); // Renvoie les résultats ou false si non trouvé
    }

}
