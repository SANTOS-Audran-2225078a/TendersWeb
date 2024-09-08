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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $motDePasse = $_POST['password'];
            echo "ID: " . htmlspecialchars($id) . "<br>";
            echo "Mot de passe: " . htmlspecialchars($motDePasse) . "<br>";

            $tenracModel = new tenracModel();
            $tenrac = $tenracModel->verifierTenrac($id, $motDePasse);
            var_dump($tenrac);
            if ($tenrac) {
                $_SESSION['tenrac'] = $tenrac;
                header('Location: /acceuil');
                exit();
            } else {
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php'; // Réafficher la vue de connexion
            }
        } else {
            // Gérer les requêtes GET si nécessaire
            require_once 'views/login.php';
        }
    }

    public function deconnecter()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /login');
    }
}
