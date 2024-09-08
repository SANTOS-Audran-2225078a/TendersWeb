<?php

require_once 'models/tenracModel.php';

class tenracController
{
    public function index()
    {
        // Affiche la vue de connexion
        require_once 'views/login.php';
    }

    public function connecter()
    {
        session_start(); // Démarre la session une fois
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $motDePasse = $_POST['password'];

            $tenracModel = new tenracModel();
            $tenrac = $tenracModel->verifierTenrac($id, $motDePasse);

            if ($tenrac) {
                // Connexion réussie, stockage de l'utilisateur en session
                $_SESSION['tenrac'] = $tenrac;
                header('Location: /acceuil');
                exit();
            } else {
                // Échec de la connexion, définir le message d'erreur
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php'; // Réafficher la vue de connexion
            }
        }
    }


    public function deconnecter()
    {
        // Déconnecter l'tenrac
        session_start();
        session_destroy();
        header('Location: /login');
    }
}
