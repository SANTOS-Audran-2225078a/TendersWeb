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

    // Récupérer tous les plats
    public function getAllPlats()
    {
        $query = $this->db->query('SELECT * FROM plat');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllIngredients()
    {
        $query = $this->db->query('SELECT * FROM ingredient');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau plat
    public function ajouterPlat($nom, $ingredients, $club_id)
    {
        try {
            $query = $this->db->prepare('INSERT INTO plat (nom, club_id) VALUES (:nom, :club_id)');
            $query->bindParam(':nom', $nom);
            $query->bindParam(':club_id', $club_id);
            $query->execute();

            $plat_id = $this->db->lastInsertId();
            $this->ajouterIngredientsAuPlat($plat_id, $ingredients);
        } catch (PDOException $e) {
            echo 'Erreur d\'ajout du plat : ' . $e->getMessage();
        }
    }


    public function modifierPlat($id, $nom, $ingredients, $club_id)
    {
        $query = $this->db->prepare('UPDATE plat SET nom = :nom, club_id = :club_id WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':club_id', $club_id);
        $query->execute();

        $this->supprimerIngredientsDuPlat($id);
        $this->ajouterIngredientsAuPlat($id, $ingredients);
    }

    // Supprimer un plat
    public function supprimerPlat($id)
    {
        $query = $this->db->prepare('DELETE FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }

    // Récupérer un plat par son ID
    public function getPlatById($id)
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les plats par club
    public function getPlatsByClub($club_id)
    {
        $query = $this->db->prepare('SELECT * FROM plat WHERE club_id = :club_id');
        $query->bindParam(':club_id', $club_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterIngredientsAuPlat($plat_id, $ingredients)
    {
        foreach ($ingredients as $ingredient_id) {
            $query = $this->db->prepare('INSERT INTO plat_ingredient (plat_id, ingredient_id) VALUES (:plat_id, :ingredient_id)');
            $query->bindParam(':plat_id', $plat_id);
            $query->bindParam(':ingredient_id', $ingredient_id);
            $query->execute();
        }
    }
    // Récupérer les ingrédients d'un plat à partir de la table associative
    // Récupérer les ingrédients d'un plat à partir de la table associative
    public function getIngredientsByPlat($plat_id)
    {
        $query = $this->db->prepare('
        SELECT ingredient.nom, ingredient.risque 
        FROM plat_ingredient 
        JOIN ingredient ON plat_ingredient.ingredient_id = ingredient.id 
        WHERE plat_ingredient.plat_id = :plat_id
    ');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);  // Renvoie les noms et l'info "aliment_a_risque"
    }


    public function supprimerIngredientsDuPlat($plat_id)
    {
        $query = $this->db->prepare('DELETE FROM plat_ingredient WHERE plat_id = :plat_id');
        $query->bindParam(':plat_id', $plat_id);
        $query->execute();
    }

}
