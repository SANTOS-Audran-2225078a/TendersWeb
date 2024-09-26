<?php

require_once 'models/RepasModel.php';
require_once 'models/PlatModel.php';
require_once 'models/ClubModel.php';

class RepasController
{
    // Afficher la liste des repas
    public function index(): void
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getAllRepas();

        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();

        require_once 'views/repas/gestion_repas.php';
    }

    // Afficher le formulaire pour ajouter un nouveau repas
    public function ajouter(): void
    {
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs(); // Liste des clubs

        require_once 'views/repas/gestion_repas.php';
    }

    // Enregistrer un nouveau repas
    public function sauvegarder(): void
{
    if (isset($_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
        $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires

        // Afficher les données pour déboguer
        var_dump($_POST); // Supprime ceci après avoir confirmé que tout est correct

        $repasModel = new RepasModel();
        $repasModel->ajouterRepas($_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
        header('Location: /repas');
    } else {
        echo 'Formulaire incomplet';
    }
}

 
    // Modifier un repas existant
    public function editer($id): void
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getRepasById($id);

        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();

        $platModel = new PlatModel();
        $plats = $platModel->getPlatsByClub($repas['adresse']); // Afficher les plats du club déjà sélectionné

        require_once 'views/repas/gestion_repas.php';
    }

    // Enregistrer les modifications d'un repas
    public function modifier(): void
    {
        if (isset($_POST['id'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
            $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires
            $repasModel = new RepasModel();
            $repasModel->modifierRepas($_POST['id'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
            header('Location: /repas');
        } else {
            echo 'Formulaire incomplet';
        }
    }

    // Charger les plats pour un club donné (appelé via JavaScript)
    public function getPlatsByClub($club_id): void
    {
        $platModel = new PlatModel();
        $plats = $platModel->getPlatsByClub($club_id);
        echo json_encode($plats); // Renvoie les plats sous forme de JSON
    }
}
