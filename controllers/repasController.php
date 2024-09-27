<?php

require_once 'models/repasModel.php';
require_once 'models/platModel.php';
require_once 'models/clubModel.php';

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
    // Enregistrer un nouveau repas
public function sauvegarder(): void
{
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
        $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires

        // Appel à la méthode ajouterRepas avec tous les arguments requis
        $repasModel = new RepasModel();
        $repasModel->ajouterRepas($_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
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
    if (isset($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
        $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires
        $repasModel = new RepasModel();

        // Appel à la méthode modifierRepas avec tous les arguments requis
        $repasModel->modifierRepas($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
        header('Location: /repas');
    } else {
        echo 'Formulaire incomplet';
    }
}

     public function supprimer($id): void
{
    if ($id) {
        var_dump($id); // Ajout temporaire pour voir si l'ID est bien récupéré
        $repasModel = new RepasModel();
        
        // Vérifier si le repas existe avant de tenter de le supprimer
        $repas = $repasModel->getRepasById($id);
        
        if ($repas) {
            $repasModel->supprimerRepas($id);
            header('Location: /repas');
            exit(); 
        } else {
            echo "Repas introuvable avec l'ID : $id";
        }
    } else {
        echo "Aucun ID de repas fourni pour la suppression.";
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
