<?php

require_once 'models/PlatModel.php';
require_once 'models/ClubModel.php';

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

        // Passer les variables à la vue
        require_once 'views/plat/gestion_plat.php';
    }

    public function ajouterPlat(): void
    {
        if (isset($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'])) {
            $platModel = new PlatModel();
            $platModel->ajouterPlat($_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids']);
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

        // Passer les variables à la vue
        require_once 'views/plat/gestion_plat.php';
    }

    public function modifierPlat(): void
    {
        if (isset($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids'])) {
            $platModel = new PlatModel();
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $_POST['club_id'], $_POST['ingredient_ids']);
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
}
