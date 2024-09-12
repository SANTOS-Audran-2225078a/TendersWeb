<?php

require_once 'models/PlatModel.php';
require_once 'models/ClubModel.php';

class PlatController
{
    // Afficher la liste des plats
    public function index()
    {
        $platModel = new PlatModel();
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        $ingredients = $platModel->getAllIngredients();

        // Récupérer les plats par club et leurs ingrédients
        $platsParClub = [];
        foreach ($clubs as $club) {
            $plats = $platModel->getPlatsByClub($club['id']);
            foreach ($plats as &$plat) {
                // Ajouter les ingrédients et leur statut "à risque" à chaque plat
                $plat['ingredients'] = $platModel->getIngredientsByPlat($plat['id']);
            }
            $platsParClub[$club['id']] = $plats;
        }

        require_once 'views/plat/gestion_plat.php';
    }



    // Sauvegarder un plat (ajouter ou modifier)
    public function sauvegarder()
    {
        $platModel = new PlatModel();
        $club_id = $_POST['club_id'];
        $ingredient_ids = $_POST['ingredient_ids']; // Récupérer les ingrédients sélectionnés

        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $ingredient_ids, $club_id);
        } else {
            $platModel->ajouterPlat($_POST['nom'], $ingredient_ids, $club_id);
        }

        header('Location: /plat');
        exit();
    }

    // Afficher la vue pour modifier un plat
    public function editer($id)
    {
        $platModel = new PlatModel();
        $plat = $platModel->getPlatById($id);

        $ingredients = $platModel->getAllIngredients();

        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs(); // Récupérer tous les clubs

        require_once 'views/plat/gestion_plat.php';
    }

    // Supprimer un plat
    public function supprimer($id)
    {
        $platModel = new PlatModel();
        $platModel->supprimerPlat($id);
        header('Location: /plat');
        exit();
    }
}
