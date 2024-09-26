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

        // Si l'utilisateur accède à '/', on redirige vers la page de connexion
        if ($url === '/') {
            $controleurNom = 'tenracController';
            $action = 'index'; // Affiche la page de connexion
        } elseif ($urlParts[0] === 'login') {
            $controleurNom = 'tenracController';
            $action = 'connecter';
        } elseif ($urlParts[0] === 'repas' && isset($urlParts[1]) && $urlParts[1] === 'getPlatsByClub' && isset($urlParts[2])) {
            // Route pour récupérer les plats d'un club en particulier
            $controleurNom = 'RepasController';
            $action = 'getPlatsByClub';
            $param = $urlParts[2];
        } elseif ($urlParts[0] === 'tenrac' && isset($urlParts[1]) && $urlParts[1] === 'index') {
            // Route pour accéder à la page d'accueil des tenracs
            $controleurNom = 'tenracController';
            $action = 'index'; 
        } elseif ($urlParts[0] === 'club') {
            $controleurNom = 'ClubController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        } elseif ($urlParts[0] === 'plat') {
            $controleurNom = 'PlatController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        } elseif ($urlParts[0] === 'repas') {
            $controleurNom = 'RepasController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        } elseif ($urlParts[0] === 'tenrac') {
            $controleurNom = 'tenracController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        } else {
            // Si aucune route ne correspond, retourne une erreur 404
            $this->pageNotFound();
            return;
        }

        // Vérifier l'existence du fichier du contrôleur
        if (file_exists("controllers/$controleurNom.php")) {
            require_once "controllers/$controleurNom.php";
            $controleur = new $controleurNom();

            // Vérifier si l'action existe dans le contrôleur
            if (method_exists($controleur, $action)) {
                if (isset($param)) {
                    $controleur->$action($param); // Passe le paramètre si disponible
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
