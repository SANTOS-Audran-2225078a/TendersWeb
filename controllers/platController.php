<?php

require_once 'models/platModel.php';
require_once 'models/clubModel.php';
 
class PlatController
{
    // Afficher la liste des plats
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

    public function ajouterPlat(): void
    {
        if (isset($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids'])) {
            $platModel = new PlatModel();
            $platModel->ajouterPlat($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids']);
            header('Location: /plat');
        } else {
            echo 'Formulaire incomplet';
        }
    }

    public function editer($id): void
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


    public function modifierPlat(): void
    {
        if (isset($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids'])) {
            $platModel = new PlatModel();
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'], $_POST['sauce_ids']);
            header('Location: /plat');
        } else {
            echo 'Formulaire incomplet';
        }
    }

    public function supprimer($id): void
    {
        $platModel = new PlatModel();
        $platModel->supprimerPlat($id);
        header('Location: /plat');
    }

    public function rechercher(): void
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
 