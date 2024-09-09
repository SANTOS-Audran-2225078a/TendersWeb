<?php

require_once 'models/clubModel.php';

class ClubController
{
    // Vérification de connexion
    private function verifierConnexion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
        }

        if (!isset($_SESSION['tenrac'])) {
            header('Location: /login'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
            exit();
        }
    }

    // Afficher la liste des clubs
    public function index()
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté avant d'afficher
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        require_once 'views/club/gestion_club.php';
    }

    // Ajouter ou modifier un club
    public function sauvegarder()
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté
        $clubModel = new ClubModel();
        
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $clubModel->modifierClub($_POST['id'], $_POST['nom'], $_POST['adresse']);
        } else {
            $clubModel->ajouterClub($_POST['nom'], $_POST['adresse']);
        }

        header('Location: /club');
        exit();
    }

    // Afficher la vue pour modifier un club
    public function editer($id)
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté
        $clubModel = new ClubModel();
        $club = $clubModel->getClubById($id);
        $clubs = $clubModel->getAllClubs();
        require_once 'views/club/gestion_club.php';
    }

    // Supprimer un club
    public function supprimer($id)
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté
        $clubModel = new ClubModel();
        $clubModel->supprimerClub($id);
        header('Location: /club');
        exit();
    }
}