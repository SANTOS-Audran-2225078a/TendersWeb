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
    /**
     * verifierTenrac
     *
     * @param  mixed $nom
     * @return array
     */
    public function verifierTenrac($nom): ?array
{
    $query = $this->db->prepare('SELECT * FROM tenrac WHERE nom = :nom AND code_securite IS NULL AND expiration IS NULL');
    $query->bindParam(':nom', $nom);
    $query->execute();

    $tenrac = $query->fetch(PDO::FETCH_ASSOC);

    // Ajout d'un log pour voir ce que la base de données renvoie
    var_dump($tenrac);

    return $tenrac ?: null; // Retourne l'utilisateur ou null si non trouvé ou si validation incomplète
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
    $query = $this->db->prepare('INSERT INTO tenrac (nom, adresse, email, password, tel, club_id, ordre_id, grade, rang, titre, dignite) 
                                 VALUES (:nom, :adresse, :email, :password, :tel, :club_id, :ordre_id, :grade, :rang, :titre, :dignite)');
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

public function modifierTenrac($id, $data): void
{
    $query = $this->db->prepare('UPDATE tenrac SET nom = :nom, adresse = :adresse, email = :email, password = :password, 
                                  tel = :tel, club_id = :club_id, ordre_id = :ordre_id, grade = :grade, rang = :rang, titre = :titre, dignite = :dignite WHERE id = :id');
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

public function ajouterTenracTemporaire($data): void
{
    $query = $this->db->prepare('INSERT INTO tenrac (nom, adresse, email, tel, club_id, ordre_id, grade, rang, titre, dignite, code_securite, expiration)
                                 VALUES (:nom, :adresse, :email, :tel, :club_id, :ordre_id, :grade, :rang, :titre, :dignite, :code_securite, :expiration)');
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

public function verifierCodeSecurite($code): ?array
{
    $query = $this->db->prepare('SELECT * FROM tenrac WHERE code_securite = :code AND expiration > NOW()');
    $query->bindParam(':code', $code);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC) ?: null;
}

public function definirMotDePasse($id, $passwordHash): void
{
    $query = $this->db->prepare('UPDATE tenrac SET password = :password, code_securite = NULL, expiration = NULL WHERE id = :id');
    $query->bindParam(':password', $passwordHash);
    $query->bindParam(':id', $id); 
    $query->execute();
}


 
public function verifierEmail($email): bool
{
    $query = $this->db->prepare('SELECT id FROM tenrac WHERE email = :email');
    $query->bindParam(':email', $email);
    $query->execute();

    return (bool) $query->fetch(PDO::FETCH_ASSOC);
}





}
 