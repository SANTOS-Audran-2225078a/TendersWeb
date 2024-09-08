<?php

require_once 'models/RepasModel.php';

class RepasController
{
    // Afficher la liste des repas
    public function index()
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getAllRepas();
        require_once 'views/repas/gestion_repas.php';
    }

    // Ajouter ou modifier un repas
    public function sauvegarder()
    {
        $repasModel = new RepasModel();
        
        // Si un ID est présent, on modifie sinon on ajoute
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $repasModel->modifierRepas($_POST['id'], $_POST['nom'], $_POST['date'], $_POST['lieu']);
        } else {
            $repasModel->ajouterRepas($_POST['nom'], $_POST['date'], $_POST['lieu']);
        }

        // Redirection après la sauvegarde
        header('Location: /repas');
        exit();
    }

    // Afficher la vue pour modifier un repas
    public function editer($id)
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getRepasById($id);
        $repasList = $repasModel->getAllRepas();
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
}
