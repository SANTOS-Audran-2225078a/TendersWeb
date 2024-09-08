<?php

require_once 'models/clubModel.php';

class ClubController
{
    // Afficher la liste des clubs
    public function index()
    {
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        require_once 'views/club/gestion_club.php';
    }

    // Ajouter ou modifier un club
    public function sauvegarder()
    {
        $clubModel = new ClubModel();
        
        // Si un ID est présent, on modifie sinon on ajoute
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $clubModel->modifierClub($_POST['id'], $_POST['nom'], $_POST['adresse']);
        } else {
            $clubModel->ajouterClub($_POST['nom'], $_POST['adresse']);
        }

        // Redirection après la sauvegarde
        header('Location: /club');
        exit();
    }

    // Afficher la vue pour modifier un club
    public function editer($id)
    {
        $clubModel = new ClubModel();
        $club = $clubModel->getClubById($id);
        $clubs = $clubModel->getAllClubs();
        require_once 'views/club/gestion_club.php';
    }

    // Supprimer un club
    public function supprimer($id)
    {
        $clubModel = new ClubModel();
        $clubModel->supprimerClub($id);
        header('Location: /club');
        exit();
    }
}
