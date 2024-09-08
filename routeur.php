<?php
class Routeur
{
    public function gererRequete()
    {
        // Récupérer l'URL
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = explode('/', trim($url, '/'));

        // Si aucun contrôleur n'est spécifié, par défaut on charge 'ClubController'
        $controleurNom = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ClubController';

        // Si aucune action n'est spécifiée, on charge l'action par défaut 'index'
        $action = isset($urlParts[1]) ? $urlParts[1] : 'index';

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
