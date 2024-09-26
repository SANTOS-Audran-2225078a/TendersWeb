<?php

class PlatModel
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

    // Récupérer toutes les sauces disponibles
    public function getAllSauces(): array
    {
        $query = $this->db->query('SELECT * FROM sauce');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les plats 
    public function getAllPlats(): array
    {
        $query = $this->db->query('SELECT * FROM plat');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un plat par ID
    public function getPlatById($id): ?array
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau plat
    public function ajouterPlat($nom, $club_id, $ingredients, $sauces): void  // Ajout de $sauces ici
{
    $query = $this->db->prepare('INSERT INTO plat (nom, club_id) VALUES (:nom, :club_id)');
    $query->bindParam(':nom', $nom);
    $query->bindParam(':club_id', $club_id);
    $query->execute();

    $plat_id = $this->db->lastInsertId();
    $this->ajouterIngredientsAuPlat($plat_id, $ingredients);
    $this->ajouterSaucesAuPlat($plat_id, $sauces);  // Ajout de sauces au plat
}


    // Modifier un plat existant
    public function modifierPlat($id, $nom, $club_id, $ingredients, $sauces): void
    {
        $query = $this->db->prepare('UPDATE plat SET nom = :nom, club_id = :club_id WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':club_id', $club_id);
        $query->execute();

        $this->supprimerIngredientsDuPlat($id);
        $this->ajouterIngredientsAuPlat($id, $ingredients);
        $this->supprimerSaucesDuPlat($id);
        $this->ajouterSaucesAuPlat($id, $sauces);
    }

    private function ajouterSaucesAuPlat($plat_id, $sauces): void
    {
        foreach ($sauces as $sauce_id) {
            $query = $this->db->prepare('INSERT INTO plat_sauce (plat_id, sauce_id) VALUES (:plat_id, :sauce_id)');
            $query->bindParam(':plat_id', $plat_id);
            $query->bindParam(':sauce_id', $sauce_id);
            $query->execute();
        }
    }

    private function supprimerSaucesDuPlat($plat_id): void
    {
        $query = $this->db->prepare('DELETE FROM plat_sauce WHERE plat_id = :plat_id');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
    }

    public function getSaucesByPlat($plat_id): array
    {
        $query = $this->db->prepare('
            SELECT sauce.* 
            FROM sauce
            JOIN plat_sauce ON sauce.id = plat_sauce.sauce_id
            WHERE plat_sauce.plat_id = :plat_id
        ');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // Supprimer un plat
    public function supprimerPlat($id): void
{
    // Supprimer les sauces associées au plat avant de supprimer le plat
    $this->supprimerSaucesDuPlat($id);

    // Supprimer les ingrédients associés au plat avant de supprimer le plat
    $this->supprimerIngredientsDuPlat($id);

    // Supprimer le plat après avoir supprimé ses dépendances
    $query = $this->db->prepare('DELETE FROM plat WHERE id = :id');
    $query->bindParam(':id', $id);
    $query->execute();
}


    // Ajouter des ingrédients à un plat
    private function ajouterIngredientsAuPlat($plat_id, $ingredients): void
    {
        foreach ($ingredients as $ingredient_id) {
            $query = $this->db->prepare('INSERT INTO plat_ingredient (plat_id, ingredient_id) VALUES (:plat_id, :ingredient_id)');
            $query->bindParam(':plat_id', $plat_id);
            $query->bindParam(':ingredient_id', $ingredient_id);
            $query->execute();
        }
    }

    // Supprimer les ingrédients d'un plat
    private function supprimerIngredientsDuPlat($plat_id): void
    {
        $query = $this->db->prepare('DELETE FROM plat_ingredient WHERE plat_id = :plat_id');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
    }

    // Récupérer les ingrédients d'un plat
    public function getIngredientsByPlat($plat_id): array
    {
        $query = $this->db->prepare('
            SELECT ingredient.nom, ingredient.id, ingredient.risque 
            FROM plat_ingredient 
            JOIN ingredient ON plat_ingredient.ingredient_id = ingredient.id 
            WHERE plat_ingredient.plat_id = :plat_id
        ');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // **Nouvelle méthode : Récupérer les plats par club**
    public function getPlatsByClub($club_id): array
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE club_id = :club_id');
        $query->bindParam(':club_id', $club_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les ingrédients disponibles
    public function getAllIngredients(): array
    {
        $query = $this->db->query('SELECT * FROM ingredient');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
