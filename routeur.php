<?php
/**
 * Routeur
 */
class Routeur
{    
    /**
     * gererRequete
     *
     * @return void
     */
    public function gererRequete()
    {
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = explode('/', trim($url, '/'));

        // Initialisation par défaut des variables
        $controleurNom = '';
        $action = '';
        $param = null;

        // Si l'utilisateur accède à '/', on redirige vers la page de connexion
        if ($url === '/') {
            $controleurNom = 'tenracController';
            $action = 'index'; // Affiche la page de connexion
        } elseif ($urlParts[0] === 'login') {
            $controleurNom = 'tenracController';
            $action = 'connecter';
        } elseif ($urlParts[0] === 'repas') {
            $controleurNom = 'repasController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';

            // Vérification de routes pour édition ou suppression avec un ID
            if (($action === 'editer' || $action === 'supprimer' || $action === 'getPlatsByClub' || $action === 'modifier') && isset($urlParts[2])) {
                $param = (int) $urlParts[2]; // Récupérer l'ID du repas
            }
        } elseif ($urlParts[0] === 'club') {
            $controleurNom = 'clubController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
            // Vérifier si c'est une route pour l'édition ou suppression avec un ID
            if (($action === 'editer' || $action === 'supprimer') && isset($urlParts[2])) {
                $param = (int) $urlParts[2]; // Récupérer l'ID du club
            }
        } elseif ($urlParts[0] === 'plat') {
            $controleurNom = 'platController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';

            // Vérifier si c'est une route pour l'édition ou suppression avec un ID
            if (($action === 'editer' || $action === 'supprimer') && isset($urlParts[2])) {
                $param = (int) $urlParts[2]; // Récupérer l'ID du plat
            }
        } elseif ($urlParts[0] === 'tenrac') {
            $controleurNom = 'tenracController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index2';

            // Vérifier si c'est une route pour l'édition ou suppression avec un ID
            if (($action === 'editer' || $action === 'supprimer') && isset($urlParts[2])) {
                $param = (int) $urlParts[2]; // Récupérer l'ID du tenrac
            }
        } else {
            // Si aucune route ne correspond, retourne une erreur 404
            $this->pageNotFound();
            return;
        }

        // Vérifier l'existence du fichier du contrôleur
        if (file_exists("controllers/$controleurNom.php")) {
            require_once __DIR__ . "/controllers/$controleurNom.php";
            $controleur = new $controleurNom();

            // Vérifier si l'action existe dans le contrôleur
            if (method_exists($controleur, $action)) {
                if (isset($param)) {
                    // Ajouter un debug pour voir si le paramètre est bien passé
                    // var_dump($param); // Utiliser pour déboguer si nécessaire
                    $controleur->$action($param); // Passe le paramètre (ex: ID du repas, club, plat, tenrac)
                } else {
                    $controleur->$action(); // Appeler l'action sans paramètre
                }
            } else {
                echo "Action $action non trouvée dans le contrôleur $controleurNom";
            }
        } else {
            echo "Contrôleur $controleurNom non trouvé";
        }
    }

    /**
     * pageNotFound
     * Affiche une page d'erreur 404 si aucune route ne correspond
     *
     * @return void
     */
    private function pageNotFound(): void
    {
        http_response_code(404);
        echo 'Erreur 404 : Page non trouvée';
    }
}
