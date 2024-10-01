<?php

require_once 'models/repasModel.php';
require_once 'models/platModel.php';
require_once 'models/clubModel.php';

/**
 * RepasController
 */
class RepasController
{
    // Afficher la liste des repas     
    /**
     * index
     *
     * @return void
     */
    public function index(): void
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getAllRepas();

        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();

        $repasModel = new RepasModel();
        $tenrac = $repasModel->getTenrac(); // Récupère la liste des tenracs

        require_once 'views/repas/gestion_repas.php';
    }

    // Afficher le formulaire pour ajouter un nouveau repas    
    /**
     * ajouter
     *
     * @return void
     */
    public function ajouter(): void
    {
        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs(); // Liste des clubs

        $repasModel = new RepasModel();
        $tenrac = $repasModel->getTenrac(); // Récupère la liste des tenracs

        require_once 'views/repas/gestion_repas.php';
    }

    // Enregistrer un nouveau repas
    // Enregistrer un nouveau repas
/**
 * sauvegarder
 *
 * @return void
 */
public function sauvegarder(): void
{

    // Récupération des données tenrac
    
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
        $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires

        // Appel à la méthode ajouterRepas avec tous les arguments requis
        $repasModel = new RepasModel();
     
        $tenrac = $repasModel->getTenrac();
        $repasModel->ajouterRepas($_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
        header('Location: /repas');
    } else {
        echo 'Formulaire incomplet';
    }
}

    // Editer un repas existant    
    /**
     * editer
     *
     * @param  mixed $id
     * @return void
     */
    public function editer($id): void
    {
        $repasModel = new RepasModel();
        $repas = $repasModel->getRepasById($id);
        $tenrac = $repasModel->getTenrac(); // Récupère la liste des tenracs

        $clubModel = new ClubModel();
        $clubs = $clubModel->getAllClubs();

        $platModel = new PlatModel();
        $plats = $platModel->getPlatsByClub($repas['adresse']); // Afficher les plats du club déjà sélectionné

        require_once 'views/repas/gestion_repas.php';
    }

    // Enregistrer les modifications d'un repas    
    /**
     * modifier
     *
     * @return void
     */
    public function modifier(): void
    {
        // si le formulaire est bien rempli
        if (isset($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
            $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires
            $repasModel = new RepasModel();

            // Appel à la méthode modifierRepas avec tous les arguments requis
            $repasModel->modifierRepas($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
            header('Location: /repas');
        } else { // sinon affiche que le formulaire est incomplet
            echo 'Formulaire incomplet';
        }
}
     
     /**
      * supprimer
      *
      * @param  mixed $id
      * @return void
      */
     public function supprimer($id): void // méthode de suppression de repas
    {
        if ($id) { // si ID fourni
            var_dump($id); // Ajout temporaire pour voir si l'ID est bien récupéré
            $repasModel = new RepasModel();
        
            // Vérifier si le repas existe avant de tenter de le supprimer
            $repas = $repasModel->getRepasById($id);
        
            if ($repas) { // si repas fourni
                $repasModel->supprimerRepas($id); // suppression du repas
                header('Location: /repas'); // redirection vers page des repas
                exit(); 
            } else { // sinon repas introuvable
                echo "Repas introuvable avec l'ID : $id";
            }
        } else { // sinon suppression impossible
            echo "Aucun ID de repas fourni pour la suppression.";
        }
    }
    
    // Charger les plats pour un club donné (appelé via JavaScript)    
    /**
     * getPlatsByClub
     *
     * @param  mixed $club_id
     * @return void
     */
    public function getPlatsByClub($club_id): void
    {
        $platModel = new PlatModel();
        $plats = $platModel->getPlatsByClub($club_id);
        echo json_encode($plats); // Renvoie les plats sous forme de JSON
    }
}
