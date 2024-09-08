<?php
class Routeur
{
    public function gererRequete()
    {
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = explode('/', trim($url, '/'));

        // Si l'utilisateur accède à '/', on redirige vers la page de connexion
        if ($url === '/') {
            $controleurNom = 'TenracController';
            $action = 'index'; // Affiche la page de connexion
        } elseif ($urlParts[0] === 'login') {
            // Redirige vers l'action 'connecter' de TenracController
            $controleurNom = 'TenracController';
            $action = 'connecter';
        } else {
            // Sinon, charger le contrôleur basé sur la première partie de l'URL
            $controleurNom = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ClubController';
            $action = isset($urlParts[1]) ? $urlParts[1] : 'index';
        }

        // Vérifier l'existence du fichier du contrôleur
        if (file_exists("controllers/$controleurNom.php")) {
            require_once "controllers/$controleurNom.php";
            $controleur = new $controleurNom();

            // Vérifier si l'action existe dans le contrôleur
            if (method_exists($controleur, $action)) {
                // Gérer les paramètres (ex: /club/editer/1)
                if (isset($urlParts[2])) {
                    $controleur->$action($urlParts[2]);
                } else {
                    $controleur->$action();
                }
            } else {
                echo "Action $action non trouvée dans le contrôleur $controleurNom";
            }
        } else {
            echo "Contrôleur $controleurNom non trouvé";
        }
    }
}
