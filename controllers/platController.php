<?php

require_once 'models/platModel.php';
require_once 'models/clubModel.php';
 
/**
 * PlatController
 */
class PlatController 
{
    // Afficher la liste des plats    
    /**
     * index
     *
     * @return void
     */
    public function index(): void
    {
        $platModel = new PlatModel();
        $clubModel = new ClubModel();

        // Récupérer tous les plats et tous les clubs
        $plats = $platModel->getAllPlats();
        $clubs = $clubModel->getAllClubs();

        // Récupérer tous les ingrédients disponibles
        $ingredients = $platModel->getAllIngredients(); 
        $sauces = $platModel->getAllSauces();

        // Passer les variables à la vue
        require_once 'views/plat/gestion_plat.php';
    }
    
    /**
     * ajouterPlat
     *
     * @return void
     */
    public function ajouterPlat(): void // Fonction permettant d'ajouter un plat
    {
        // si le formulaire d'ajout de plat est rempli
        if (isset($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids'])) {
            $platModel = new PlatModel();
            // alors ajout du plat
            $platModel->ajouterPlat($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids']);
            header('Location: /plat');
        } else { // sinon affiche que le formulaire est incomplet
            echo 'Formulaire incomplet';
        }
    }
    
    /**
     * editer
     *
     * @param  mixed $id
     * @return void
     */
    public function editer($id): void // méthode d'édition de plat
    {
        $platModel = new PlatModel();
        $clubModel = new ClubModel();
    
        // Récupérer le plat par ID
        $plat = $platModel->getPlatById($id);
    
        // Récupérer les ingrédients du plat et tous les clubs 
        $ingredients = $platModel->getAllIngredients();
        $platIngredients = $platModel->getIngredientsByPlat($id);
        $clubs = $clubModel->getAllClubs();
        $sauces = $platModel->getAllSauces();
        $platSauces = $platModel->getSaucesByPlat($id);

        // **Récupérer tous les plats** (Ajout)
        $plats = $platModel->getAllPlats();  // Cette ligne permet de passer les plats à la vue

        // Passer les variables à la vue
        require_once 'views/plat/gestion_plat.php';
    }

    
    /**
     * modifierPlat
     *
     * @return void
     */
    public function modifierPlat(): void // méthode de modification de plat
    {
        // si le formulaire de modification est rempli
        if (isset($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids'])) {
            $platModel = new PlatModel();
            // alors modification du plat
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids']);
            header('Location: /plat');
        } else { // sinon affiche que le formulaire est incomplet
            echo 'Formulaire incomplet';
        }
    }
    
    /**
     * supprimer
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimer($id): void // méthode de suppression de plat
    {
        $platModel = new PlatModel();
        $platModel->supprimerPlat($id);
        header('Location: /plat');
    }
    
    /**
     * rechercher
     *
     * @return void
     */
    public function rechercher(): void // méthode de recherche d'un plat (dans la base de données)
    {
        if (isset($_GET['query'])) {
            $platModel = new PlatModel();
            $clubModel = new ClubModel();

            $query = $_GET['query'];

            // Récupérer les plats en fonction des ingrédients (partiels ou complets)
            $plats = $platModel->rechercherPlatsParIngredients($query);
            $clubs = $clubModel->getAllClubs();
            $ingredients = $platModel->getAllIngredients(); 
            $sauces = $platModel->getAllSauces();

            // Afficher les résultats de recherche dans la même vue
            require_once 'views/plat/gestion_plat.php';
        } else {
            header('Location: /plat');
        }
    }
}
 