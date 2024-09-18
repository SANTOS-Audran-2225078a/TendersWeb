<?php

/**
 * tenracModel
 */
class tenracModel
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
    
    /**
     * verifierTenrac
     *
     * @param  mixed $nom
     * @param  mixed $motDePasse
     * @return mixed
     */
    public function verifierTenrac($nom, $motDePasse): mixed
    {
        if ($this->db === null) {
            throw new Exception('La connexion à la base de données a échoué.');
        }

        $query = $this->db->prepare('SELECT * FROM tenrac WHERE nom = :nom');
        $query->bindParam(':nom', $nom);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }
        if ($result['password'] == $motDePasse) {
            return $result;
        } else {
            return false;
        }
    }
}