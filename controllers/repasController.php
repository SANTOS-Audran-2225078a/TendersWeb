<?php

require_once 'models/repasModel.php';
require_once 'models/platModel.php';
require_once 'models/clubModel.php';

class RepasController
{
    // Afficher la liste des repas
    public function index()
    {
        $repasModel = new RepasModel();
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();  // Récupérer tous les clubs pour les afficher dans le formulaire
        $repas = $repasModel->getAllRepas();
        require_once 'views/repas/gestion_repas.php';
    }

    // Ajouter ou modifier un repas
    public function sauvegarder()
{
    $repasModel = new RepasModel();
    $clubModel = new ClubModel();

    // Récupérer le club sélectionné
    $club_id = $_POST['club_id'];

    // Récupérer l'adresse du club
    $club = $clubModel->getClubById($club_id);
    $adresse = $club['adresse'];

    // Valider que le nombre de plats correspond aux participants
    $participants = $_POST['participants'];
    $plats = json_decode($_POST['plats'], true); // Les plats sélectionnés
    $totalPlats = array_sum($plats); // Compter le nombre total de plats sélectionnés

    if ($totalPlats < $participants) {
        // Erreur : Pas assez de plats sélectionnés
        echo 'Le nombre de plats sélectionnés ne correspond pas au nombre de participants.';
        return;
    }

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        // Modification du repas avec l'adresse du club
        $repasModel->modifierRepas($_POST['id'], $adresse, $_POST['date'], $participants, $_POST['plats'], $club_id);
    } else {
        // Création d'un nouveau repas avec l'adresse du club
        $repasModel->ajouterRepas($adresse, $_POST['date'], $participants, $_POST['plats'], $club_id);
    }

    header('Location: /repas');
    exit();
}



    // Afficher la vue pour modifier un repas
    public function editer($id)
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getRepasById($id);
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();
        require_once 'views/repas/gestion_repas.php';
    }

    // Supprimer un repas
    public function supprimer($id)
    {
        $repasModel = new RepasModel();
        $repasModel->supprimerRepas($id);
        header('Location: /repas');
        exit();
    }

    // Méthode Ajax pour obtenir les plats par club
    public function getPlatsByClub($club_id)
{
    $platModel = new PlatModel();
    $plats = $platModel->getPlatsByClub($club_id);
    echo json_encode($plats); // Retourner les plats au format JSON
}

}
