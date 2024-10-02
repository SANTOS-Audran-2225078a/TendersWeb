<?php

/**
 * TenracModel
 */
class TenracModel
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

    // Méthode pour vérifier les identifiants du tenrac dans la base de données     
    /**
     * verifierTenrac
     *
     * @param  mixed $nom
     * @return array
     */
    public function verifierTenrac($nom): ?array
    {
        // requête SQL de vérification des identifiants de tenrac
        $query = $this->db->prepare('SELECT * FROM tenrac WHERE nom = :nom AND code_securite IS NULL AND expiration IS NULL');
        $query->bindParam(':nom', $nom);
        $query->execute(); // exécution de requête

        $tenrac = $query->fetch(PDO::FETCH_ASSOC);

        

        return $tenrac ?: null; // Retourne l'utilisateur ou null si non trouvé ou si validation incomplète
    }

    // Récupérer tous les tenracs (utilisé pour l'affichage des adresses dans la gestion des repas)    
    /**
     * getAllTenracs
     *
     * @return array
     */
    public function getAllTenracs(): array
    {
        // requête SQL de récupération de TOUS les tenracs
        $query = $this->db->query('SELECT * FROM tenrac');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau tenrac    
    /**
     * ajouterTenrac
     *
     * @param  mixed $data
     * @return void
     */
    public function ajouterTenrac($data): void
    {
        // requête d'insertion de tenrac dans la base de données
        $query = $this->db->prepare('INSERT INTO tenrac (nom, adresse, email, password, tel, club_id, ordre_id, grade, rang, titre, dignite) 
                                 VALUES (:nom, :adresse, :email, :password, :tel, :club_id, :ordre_id, :grade, :rang, :titre, :dignite)');
        // exécution de requête
        $query->execute([
            ':nom' => $data['nom'],
            ':adresse' => $data['adresse'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':tel' => $data['tel'],
            ':club_id' => $data['club_id'],
            ':ordre_id' => $data['ordre_id'],
            ':grade' => $data['grade'],
            ':rang' => $data['rang'],
            ':titre' => $data['titre'],
            ':dignite' => $data['dignite']
        ]);
    }
    
    /**
     * modifierTenrac
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return void
     */
    public function modifierTenrac($id, $data): void
    {
        // requête de mise à jour d'un tenrac
        $query = $this->db->prepare('UPDATE tenrac SET nom = :nom, adresse = :adresse, email = :email, password = :password, 
                                  tel = :tel, club_id = :club_id, ordre_id = :ordre_id, grade = :grade, rang = :rang, titre = :titre, dignite = :dignite WHERE id = :id');
        // exécution de requête
        $query->execute([
            ':id' => $id,
            ':nom' => $data['nom'],
            ':adresse' => $data['adresse'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':tel' => $data['tel'],
            ':club_id' => $data['club_id'],
            ':ordre_id' => $data['ordre_id'],
            ':grade' => $data['grade'],
            ':rang' => $data['rang'],
            ':titre' => $data['titre'],
            ':dignite' => $data['dignite']
        ]);
    }

    
    /**
     * supprimerTenrac
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerTenrac($id): void // méthode pour supprimer un tenrac de la base de données
    {
        // requête de suppression
        $query = $this->db->prepare('DELETE FROM tenrac WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute(); // exécution de requête
    }
    
    /**
     * getTenracById
     *
     * @param  mixed $id
     * @return array
     */
    public function getTenracById(int $id): ?array // méthode pour récupérer des tenracs en fonction de l'ID
    {
        // requête SQL de récupération
        $query = $this->db->prepare('SELECT * FROM tenrac WHERE id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute(); // exécution de requête

        $tenrac = $query->fetch(PDO::FETCH_ASSOC);

        return $tenrac ?: null;
    }
    
    /**
     * ajouterTenracTemporaire
     *
     * @param  mixed $data
     * @return void
     */
    public function ajouterTenracTemporaire($data): void // méthode pour ajouter temporairement un tenrac
    {
        // requête SQL d'insertion
        $query = $this->db->prepare('INSERT INTO tenrac (nom, adresse, email, tel, club_id, ordre_id, grade, rang, titre, dignite, code_securite, expiration)
                                 VALUES (:nom, :adresse, :email, :tel, :club_id, :ordre_id, :grade, :rang, :titre, :dignite, :code_securite, :expiration)');
        // exécution de requête
        $query->execute([
            ':nom' => $data['nom'],
            ':adresse' => $data['adresse'],
            ':email' => $data['email'],
            ':tel' => $data['tel'],
            ':club_id' => $data['club_id'],
            ':ordre_id' => $data['ordre_id'],
            ':grade' => $data['grade'],
            ':rang' => $data['rang'],
            ':titre' => $data['titre'],
            ':dignite' => $data['dignite'],
            ':code_securite' => $data['code_securite'],
            ':expiration' => $data['expiration']
        ]);
    }
    
    /**
     * verifierCodeSecurite
     *
     * @param  mixed $code
     * @return array
     */
    public function verifierCodeSecurite($code): ?array // méthode de vérification du code de sécurité
    {
        // requête SQL de récupération
        $query = $this->db->prepare('SELECT * FROM tenrac WHERE code_securite = :code AND expiration > NOW()');
        $query->bindParam(':code', $code);
        $query->execute(); // exécution de requête

        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    /**
     * definirMotDePasse
     *
     * @param  mixed $id
     * @param  mixed $passwordHash
     * @return void
     */
    public function definirMotDePasse($id, $passwordHash): void // méthode de définition d'un mot de passe
    {
        // requête SQL de mise à jour 
        $query = $this->db->prepare('UPDATE tenrac SET password = :password, code_securite = NULL, expiration = NULL WHERE id = :id');
        $query->bindParam(':password', $passwordHash);
        $query->bindParam(':id', $id); 
        $query->execute(); // exécution de requête
    }
    
    /**
     * verifierEmail
     *
     * @param  mixed $email
     * @return bool
     */
    public function verifierEmail($email): bool // méthode de vérification de l'email
    {
        // requête SQL de récupération
        $query = $this->db->prepare('SELECT id FROM tenrac WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute(); // exécution de requête

        return (bool) $query->fetch(PDO::FETCH_ASSOC);
    }
}
 