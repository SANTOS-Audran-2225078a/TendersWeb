<?php

require_once 'models/tenracModel.php';
require_once 'models/repasModel.php';

/**
 * tenracController
 */
class tenracController
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        require_once 'views/login.php';
    }
    
    /**
     * connecter
     *
     * @return void
     */
    public function connecter()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Vérifie si une session est active avant de démarrer une nouvelle session
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $motDePasse = $_POST['password'];

            $tenracModel = new tenracModel();
            $tenrac = $tenracModel->verifierTenrac($nom, $motDePasse);

            if ($tenrac) {
                // Connexion réussie, stockage de l'utilisateur en session
                $_SESSION['tenrac'] = $tenrac;
                header('Location: /tenrac/acceuil'); // Redirige vers la page d'accueil relative
                exit();
            } else {
                // Échec de la connexion, définir le message d'erreur
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php'; // Réafficher la vue de connexion
            }
        }
    }

    
    /**
     * acceuil
     *
     * @return void
     */
    public function acceuil()
    {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['tenrac'])) {
            $tenrac = $_SESSION['tenrac'];

            // Récupérer les repas importants
            $repasModel = new RepasModel();
            $repasImportant = $repasModel->getRepasImportant(); // Méthode à ajouter dans le modèle

            $data = [
                'nom' => $tenrac['nom'],
                'email' => $tenrac['email'],
                'tel' => $tenrac['tel'],
                'adresse' => $tenrac['adresse'],
                'grade' => $tenrac['grade'],
                'repasImportant' => $repasImportant // Ajouter les repas dans la vue
            ];

            // Charger la vue avec les données
            require_once 'views/acceuil.php';
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            header('Location: /login');
            exit();
        }
    }

    
    /**
     * deconnecter
     *
     * @return void
     */
    public function deconnecter()
    {
        session_start();
        $_SESSION = []; // Réinitialiser toutes les variables de session
        session_destroy();
        header('Location: /');
        exit();
    }

}