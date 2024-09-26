<?php

require_once 'models/clubModel.php';

/**
 * ClubController
 */
class ClubController
{
    // Vérification de connexion    
    /**
     * verifierConnexion
     *
     * @return void
     */
    private function verifierConnexion(): void
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
    /**
     * index
     *
     * @return void
     */
    public function index(): void
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté avant d'afficher
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        $isEditing = false;
        require_once 'views/club/gestion_club.php';
    }

    // Ajouter ou modifier un club    
    /**
     * sauvegarder
     *
     * @return void
     */
    public function sauvegarder(): void
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
    /**
     * editer
     *
     * @param  mixed $id
     * @return void
     */
    public function editer($id): void
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté
        $clubModel = new ClubModel();
        $club = $clubModel->getClubById($id);
        $clubs = $clubModel->getAllClubs();
        $isEditing = true;
        require_once 'views/club/gestion_club.php';
    }

    // Supprimer un club    
    /**
     * supprimer
     *
     * @param  mixed $id
     * @return void
     */
    public function supprimer($id): void
    {
        $this->verifierConnexion(); // Vérifie si l'utilisateur est connecté
        $clubModel = new ClubModel();
        $clubModel->supprimerClub($id);
        header('Location: /club');
        exit();
    }
}