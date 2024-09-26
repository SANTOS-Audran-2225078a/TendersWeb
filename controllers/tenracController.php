<?php

require_once 'models/tenracModel.php';

class tenracController
{
    public function index(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Vérifie si une session est active
    }

    // Si l'utilisateur est connecté, rediriger vers la page de gestion des tenracs
    if (isset($_SESSION['tenrac'])) {
        /*$tenracModel = new TenracModel();
        $tenracs = $tenracModel->getAllTenracs(); // Récupère tous les tenracs*/
        require_once 'views/accueil.php'; // Affiche la page de gestion des tenracs
    } else {
        // Si l'utilisateur n'est pas connecté, afficher la page de connexion
        require_once 'views/login.php';
    } 
}

public function index2(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Vérifie si une session est active
    }

    // Si l'utilisateur est connecté, rediriger vers la page de gestion des tenracs
    if (isset($_SESSION['tenrac'])) {
        $tenracModel = new TenracModel();
        $tenracs = $tenracModel->getAllTenracs(); // Récupère tous les tenracs*/
        require_once 'views/tenrac/gestion_tenrac.php'; // Affiche la page de gestion des tenracs
    } else {
        // Si l'utilisateur n'est pas connecté, afficher la page de connexion
        require_once 'views/login.php';
    } 
}

    public function connecter(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $motDePasse = $_POST['password'];

            $tenracModel = new TenracModel();
            $tenrac = $tenracModel->verifierTenrac($nom, $motDePasse);

            if ($tenrac) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
                }

                // Stocker l'utilisateur dans la session
                $_SESSION['tenrac'] = $tenrac;

                header('Location: /tenrac/accueil');
                exit();
            } else {
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php';
            }
        }
    }

    public function accueil(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session si elle n'est pas déjà démarrée
        }

        if (isset($_SESSION['tenrac'])) {
            $tenrac = $_SESSION['tenrac'];
            require_once 'views/accueil.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function deconnecter(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
        }

        session_destroy();
        header('Location: /');
        exit();
    }
}
