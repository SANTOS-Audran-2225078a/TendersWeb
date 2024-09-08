<?php

require_once 'models/tenracModel.php';

class tenracController
{
    public function index()
    {
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
                header('Location: /tenrac/acceuil'); // Redirige vers la page d'accueil relative
                exit();
            } else {
                // Échec de la connexion, définir le message d'erreur
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php'; // Réafficher la vue de connexion
            }
        }
    }


    public function acceuil()
    {
        // Vérifier si l'tenrac est connecté
        if (isset($_SESSION['tenrac'])) {
            $tenrac = $_SESSION['tenrac'];
            $data = [
                'nom' => $tenrac['nom'],
                'email' => $tenrac['email'],
                'tel' => $tenrac['tel'],
                'adresse' => $tenrac['adresse'],
                'grade' => $tenrac['grade']
            ];
            // Charger la vue avec les données
            require_once 'views/acceuil.php';
        } else {
            // Si l'tenrac n'est pas connecté, rediriger vers la page de connexion
            header('Location: /login');
            exit();
        }
    }

    public function deconnecter()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
