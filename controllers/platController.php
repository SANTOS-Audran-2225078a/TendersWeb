<?php

require_once 'models/platModel.php';
require_once 'models/clubModel.php';

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

    // Afficher la vue pour ajouter un plat
    public function ajouter()
    {
        $platModel = new PlatModel();
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        $ingredients = $platModel->getAllIngredients();

        require_once 'views/plat/gestion_plats.php';
    }

    // Afficher la vue pour modifier un plat
    public function editer($id)
    {
        $platModel = new PlatModel();
        $plat = $platModel->getPlatById($id);
        $ingredients = $platModel->getAllIngredients();
        $plat['ingredients'] = $platModel->getIngredientsByPlat($plat['id']);
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();

        // Assurez-vous que $plat et $ingredients sont bien définis et non vides
        if (!$plat || !$ingredients) {
            echo "Données manquantes";
            exit();
        }

        require_once 'views/plat/modifier_plat.php';
    }


    // Ajouter un nouveau plat
    public function ajouterPlat()
    {

        if (isset($_POST['nom']) && isset($_POST['ingredient_ids']) && isset($_POST['club_id'])) {
            $platModel = new PlatModel();
            $club_id = $_POST['club_id'];
            $ingredient_ids = $_POST['ingredient_ids'];
            $nom = $_POST['nom'];

            $platModel->ajouterPlat($nom, $ingredient_ids, $club_id);

            header('Location: /plat');
            exit();
        } else {
            echo "Les données du formulaire sont manquantes";
        }
    }


    // Modifier un plat existant
    public function modifierPlat()
    {
        $platModel = new PlatModel();
        $club_id = $_POST['club_id'];
        $ingredient_ids = $_POST['ingredient_ids'];

        $platModel->modifierPlat($_POST['id'], $_POST['nom'], $ingredient_ids, $club_id);

        header('Location: /plat');
        exit();
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
