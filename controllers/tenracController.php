<?php

require_once 'models/tenracModel.php';
require_once 'models/clubModel.php';

class tenracController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) { 
            session_start(); // Vérifie si une session est active
        }

        if (isset($_SESSION['tenrac'])) {
            require_once 'views/accueil.php'; // Affiche la page de gestion des tenracs
        } else {
            require_once 'views/login.php'; // Si non connecté, redirige vers la page de connexion
        } 
    }

    public function index2(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Vérifie si une session est active
        }

        if (isset($_SESSION['tenrac'])) {
            $tenracModel = new TenracModel();
            $tenracs = $tenracModel->getAllTenracs(); // Récupère tous les tenracs

            $clubModel = new ClubModel();
            $clubs = $clubModel->getAllClubs(); // Récupère tous les clubs

            require_once 'views/tenrac/gestion_tenrac.php'; // Affiche la page de gestion des tenracs
        } else {
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

    // Méthode pour sauvegarder un Tenrac (ajout ou modification)
    public function sauvegarder(): void
{
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['email'], $_POST['password'], $_POST['tel'], $_POST['grade'], $_POST['rang'], $_POST['titre'], $_POST['dignite'])) {
        $tenracModel = new TenracModel();
        $tenracData = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'tel' => $_POST['tel'],
            'club_id' => !empty($_POST['club_id']) ? $_POST['club_id'] : null,
            'ordre_id' => !empty($_POST['ordre_id']) ? $_POST['ordre_id'] : null,
            'grade' => $_POST['grade'],
            'rang' => $_POST['rang'],
            'titre' => $_POST['titre'],
            'dignite' => $_POST['dignite']
        ];

        // Si on est en mode édition (id existant), on met à jour
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $tenracModel->modifierTenrac($_POST['id'], $tenracData);
        } else {
            // Sinon on ajoute un nouveau Tenrac
            $tenracModel->ajouterTenrac($tenracData);
        }

        header('Location: /tenrac');
        exit();
    } else {
        echo 'Formulaire incomplet';
    }
}


    // Méthode pour supprimer un Tenrac
    public function supprimer($id): void
    {
        if ($id) {
            $tenracModel = new TenracModel();
            $tenracModel->supprimerTenrac($id); // Appelle la méthode pour supprimer le Tenrac dans le modèle

            header('Location: /tenrac'); // Redirige vers la gestion des tenracs après suppression
            exit();
        } else {
            echo "ID non fourni pour la suppression.";
        }
    }

    public function editer(int $id): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Démarre la session si elle n'est pas déjà démarrée
    }

    if (isset($_SESSION['tenrac'])) {
        $tenracModel = new TenracModel();
        $tenrac = $tenracModel->getTenracById($id); // Récupère le tenrac par son ID

        if ($tenrac) {
            $clubModel = new ClubModel();
            $clubs = $clubModel->getAllClubs(); // Récupère tous les clubs pour afficher dans la liste déroulante

            // Affiche la page de gestion du tenrac avec les données à modifier
            require_once 'views/tenrac/gestion_tenrac.php';
        } else {
            echo "Aucun tenrac trouvé avec l'ID : " . $id;
        }
    } else {
        header('Location: /login');
        exit();
    }
}

}
