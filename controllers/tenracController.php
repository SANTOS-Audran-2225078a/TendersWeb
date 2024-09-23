<?php

require_once 'models/tenracModel.php';

class tenracController
{
    public function index(): void
    {
        require_once 'views/login.php';
    }

    public function connecter(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $motDePasse = $_POST['password'];

            $tenracModel = new tenracModel();
            $tenrac = $tenracModel->verifierTenrac($nom, $motDePasse);

            if ($tenrac) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
                }

                $_SESSION['tenrac'] = $tenrac;
                header('Location: /tenrac/acceuil');
                exit();
            } else {
                $messageErreur = "Identifiant ou mot de passe incorrect.";
                require_once 'views/login.php';
            }
        }
    }

    public function acceuil(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
        }

        if (isset($_SESSION['tenrac'])) {
            $tenrac = $_SESSION['tenrac'];
            require_once 'views/acceuil.php';
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
