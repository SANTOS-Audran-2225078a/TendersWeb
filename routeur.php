
/**
 * Routeur
 */<?php
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

        // Si l'utilisateur accède à '/', on redirige vers la page de connexion
        if ($url === '/') {
            $controleurNom = 'tenracController';
            $action = 'index'; // Affiche la page de connexion
        } elseif ($urlParts[0] === 'login') {
            $controleurNom = 'tenracController';
            $action = 'connecter';
        } elseif ($urlParts[0] === 'repas' && isset($urlParts[1]) && $urlParts[1] === 'getPlatsByClub' && isset($urlParts[2])) {
            // Nouvelle route pour récupérer les plats d'un club en particulier
            $controleurNom = 'RepasController';
            $action = 'getPlatsByClub';
            $param = $urlParts[2];
        } else {
            $controleurNom = !empty($urlParts[0]) ? $urlParts[0] . 'Controller' : 'ClubController'; // Pas de ucfirst()
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        }

        // Vérifier l'existence du fichier du contrôleur
        if (file_exists("controllers/$controleurNom.php")) {
            require_once "controllers/$controleurNom.php";
            $controleur = new $controleurNom();

            if (method_exists($controleur, $action)) {
                if (isset($urlParts[2])) {
                    $controleur->$action($urlParts[2]); // Passe le paramètre si disponible
                } else {
                    $controleur->$action(); // Sans paramètre
                }
            } else {
                echo "Action $action non trouvée dans le contrôleur $controleurNom";
            }
        } else {
            echo "Contrôleur $controleurNom non trouvé";
        }
    }
}

