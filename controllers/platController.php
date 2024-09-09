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

        // Récupérer les plats par club
        $platsParClub = [];
        foreach ($clubs as $club) {
            $platsParClub[$club['id']] = $platModel->getPlatsByClub($club['id']);
        }

        require_once 'views/plat/gestion_plat.php';
    }

    // Sauvegarder un plat (ajouter ou modifier)
    public function sauvegarder()
    {
        $platModel = new PlatModel();
        
        // Récupérer le club sélectionné
        $club_id = $_POST['club_id'];

        if (isset($_POST['id']) && $_POST['id'] !== '') {
            // Modification du plat
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $_POST['ingredients'], $_POST['aliment_a_risque'], $club_id);
        } else {
            // Création d'un nouveau plat
            $platModel->ajouterPlat($_POST['nom'], $_POST['ingredients'], $_POST['aliment_a_risque'], $club_id);
        }

        header('Location: /plat');
        exit();
    }

    // Afficher la vue pour modifier un plat
    public function editer($id)
    {
        $platModel = new PlatModel();
        $plat = $platModel->getPlatById($id);

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
