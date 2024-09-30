<?php

/**
 * PlatModel
 */
class PlatModel
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

    // Récupérer toutes les sauces disponibles (dans la base de données)
    /**
     * getAllSauces
     *
     * @return array
     */
    public function getAllSauces(): array
    {
        // requête de récupération des sauces disponibles
        $query = $this->db->query('SELECT * FROM sauce');
        return $query->fetchAll(PDO::FETCH_ASSOC); // retourne le tableau des sauces
    }

    // Récupérer tous les plats (dans la base)
    /**
     * getAllPlats
     *
     * @return array
     */
    public function getAllPlats(): array
    {
        // requête de récupération des plats
        $query = $this->db->query('SELECT * FROM plat');
        return $query->fetchAll(PDO::FETCH_ASSOC); // retourne le tableau des plats
    }

    // Récupérer un plat par ID (dans la base)   
    /**
     * getPlatById
     *
     * @param  mixed $id
     * @return array
     */
    public function getPlatById($id): ?array
    {
        // requête de récupération de plat en utilisant l'ID
        $query = $this->db->prepare('SELECT * FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute(); // exécution de la requête
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau plat dans la base de données
    /**
     * ajouterPlat
     *
     * @param  mixed $nom
     * @param  mixed $club_id
     * @param  mixed $ingredients
     * @param  mixed $sauces
     * @return void
     */
    public function ajouterPlat($nom, $club_id, $ingredients, $sauces): void  // Ajout de $sauces ici
    {
        // requête d'insertion de plat
        $query = $this->db->prepare('INSERT INTO plat (nom, club_id) VALUES (:nom, :club_id)');
        $query->bindParam(':nom', $nom);
        $query->bindParam(':club_id', $club_id);
        $query->execute(); // exécution de la requête

        $plat_id = $this->db->lastInsertId();
        $this->ajouterIngredientsAuPlat($plat_id, $ingredients); // ajout d'ingrédients au plat
        $this->ajouterSaucesAuPlat($plat_id, $sauces);  // Ajout de sauces au plat
    }


    // Modifier un plat existant dans la base de données   
    /**
     * modifierPlat
     *
     * @param  mixed $id
     * @param  mixed $nom
     * @param  mixed $club_id
     * @param  mixed $ingredients
     * @param  mixed $sauces
     * @return void
     */
    public function modifierPlat($id, $nom, $club_id, $ingredients, $sauces): void
    {
        // requête de mise à jour de plat
        $query = $this->db->prepare('UPDATE plat SET nom = :nom, club_id = :club_id WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':club_id', $club_id);
        $query->execute(); // exécution de la requête

        $this->supprimerIngredientsDuPlat($id); // supprimer un/plusieurs ingrédients du plat
        $this->ajouterIngredientsAuPlat($id, $ingredients); // en ajouter un
        $this->supprimerSaucesDuPlat($id); // supprimer une/plusieurs sauces du plat
        $this->ajouterSaucesAuPlat($id, $sauces); // ajouter une/plusieurs sauces du plat
    }
    
    /**
     * ajouterSaucesAuPlat
     *
     * @param  mixed $plat_id
     * @param  mixed $sauces
     * @return void
     */
    private function ajouterSaucesAuPlat($plat_id, $sauces): void // méthode d'ajout de sauces à un plat
    {
        foreach ($sauces as $sauce_id) {
            // requête SQL pour insérer une sauce dans un plat
            $query = $this->db->prepare('INSERT INTO plat_sauce (plat_id, sauce_id) VALUES (:plat_id, :sauce_id)');
            $query->bindParam(':plat_id', $plat_id);
            $query->bindParam(':sauce_id', $sauce_id);
            $query->execute(); // exécution de la requête
        }
    }
    
    /**
     * supprimerSaucesDuPlat
     *
     * @param  mixed $plat_id
     * @return void
     */
    private function supprimerSaucesDuPlat($plat_id): void // méthode de suppression de sauces d'un plat
    {
        // requête de suppression de sauces d'un plat
        $query = $this->db->prepare('DELETE FROM plat_sauce WHERE plat_id = :plat_id');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute(); // exécution de la requête
    }
    
    /**
     * getSaucesByPlat
     *
     * @param  mixed $plat_id
     * @return array
     */
    public function getSaucesByPlat($plat_id): array // getter
    {
        // requête SQL pour récupérer les sauces qui vont avec un plat
        $query = $this->db->prepare('
            SELECT sauce.* 
            FROM sauce
            JOIN plat_sauce ON sauce.id = plat_sauce.sauce_id
            WHERE plat_sauce.plat_id = :plat_id
        ');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute(); // exécution de la requête
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supprimer un plat dans la base de données
    /**
     * supprimerPlat
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimerPlat($id): void
{
    // Supprimer les sauces associées au plat avant de supprimer le plat
    $this->supprimerSaucesDuPlat($id);

    // Supprimer les ingrédients associés au plat avant de supprimer le plat
    $this->supprimerIngredientsDuPlat($id);

    // Supprimer le plat après avoir supprimé ses dépendances (toujours dans la base)
    $query = $this->db->prepare('DELETE FROM plat WHERE id = :id');
    $query->bindParam(':id', $id);
    $query->execute(); // exécution de requête
}


    // Ajouter des ingrédients à un plat dans la base de données
    /**
     * ajouterIngredientsAuPlat
     *
     * @param  mixed $plat_id
     * @param  mixed $ingredients
     * @return void
     */
    private function ajouterIngredientsAuPlat($plat_id, $ingredients): void
    {
        foreach ($ingredients as $ingredient_id) {
            // requête d'insertion d'ingrédients à un plat
            $query = $this->db->prepare('INSERT INTO plat_ingredient (plat_id, ingredient_id) VALUES (:plat_id, :ingredient_id)');
            $query->bindParam(':plat_id', $plat_id);
            $query->bindParam(':ingredient_id', $ingredient_id);
            $query->execute(); // exécution de requête
        }
    }

    // Supprimer les ingrédients d'un plat dans la base de données
    /**
     * supprimerIngredientsDuPlat
     *
     * @param  mixed $plat_id
     * @return void
     */
    private function supprimerIngredientsDuPlat($plat_id): void
    {
        // requête de suppression d'ingrédients d'un plat
        $query = $this->db->prepare('DELETE FROM plat_ingredient WHERE plat_id = :plat_id');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute(); // exécution de requête
    }

    // Récupérer les ingrédients d'un plat (depuis la base de données)
    /**
     * getIngredientsByPlat
     *
     * @param  mixed $plat_id
     * @return array
     */
    public function getIngredientsByPlat($plat_id): array // getter
    {
        // requête de récupération des ingrédients d'un plat
        $query = $this->db->prepare('
            SELECT ingredient.nom, ingredient.id, ingredient.risque 
            FROM plat_ingredient 
            JOIN ingredient ON plat_ingredient.ingredient_id = ingredient.id 
            WHERE plat_ingredient.plat_id = :plat_id
        ');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute(); // exécution de requête
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // **Nouvelle méthode : Récupérer les plats par club**    
    /**
     * getPlatsByClub
     *
     * @param  mixed $club_id
     * @return array
     */
    public function getPlatsByClub($club_id): array // getter
    {
        // requête de plats par club
        $query = $this->db->prepare('SELECT * FROM plat WHERE club_id = :club_id');
        $query->bindParam(':club_id', $club_id);
        $query->execute(); // exécution de requête
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les ingrédients disponibles depuis la base de données   
    /**
     * getAllIngredients
     *
     * @return array
     */
    public function getAllIngredients(): array
    {
        // requête de récupération de TOUS les ingrédients
        $query = $this->db->query('SELECT * FROM ingredient');
        return $query->fetchAll(PDO::FETCH_ASSOC);  
    }
    
    /**
     * rechercherPlatsParIngredients
     *
     * @param  mixed $query
     * @return array
     */
    public function rechercherPlatsParIngredients($query): array // méthode de recherche de plats en fonction des ingrédients
    {
        // Requête SQL pour rechercher les plats contenant un ou plusieurs ingrédients partiels
        $searchQuery = "%" . $query . "%";

        $query = $this->db->prepare("
            SELECT DISTINCT p.* 
            FROM plat p
            JOIN plat_ingredient pi ON p.id = pi.plat_id
            JOIN ingredient i ON pi.ingredient_id = i.id
            WHERE i.nom LIKE :query
        ");
        $query->bindParam(':query', $searchQuery);
        $query->execute(); // exécution de requête

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}
