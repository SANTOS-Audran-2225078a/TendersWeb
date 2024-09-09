<?php

require_once 'models/PlatModel.php';

class PlatController
{
    // Afficher la liste des plats
    public function index()
    {
        $platModel = new PlatModel();
        $plats = $platModel->getAllPlats();
        require_once 'views/plat/gestion_plat.php';
    }

    // Ajouter ou modifier un plat
    public function sauvegarder()
    {
        $platModel = new PlatModel();

        // Si un ID est présent, on modifie sinon on ajoute
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $platModel->modifierPlat($_POST['id'], $_POST['nom'], $_POST['ingredients'], $_POST['aliment_a_risque']);
        } else {
            $platModel->ajouterPlat($_POST['nom'], $_POST['ingredients'], $_POST['aliment_a_risque']);
        }

        // Redirection après la sauvegarde
        header('Location: /plat');
        exit();
    }

    // Afficher la vue pour modifier un plat
    public function editer($id)
    {
        $platModel = new PlatModel();
        $plat = $platModel->getPlatById($id);
        $plats = $platModel->getAllPlats();
        require_once 'views/plat/gestion_plat.php';
    }

    // Supprimer un plat
    public function supprimer($id)
    {
        $platModel = new PlatModel();
        $platModel->supprimerPlat($id);
        header('Location: /plat');
        exit();
    }
}