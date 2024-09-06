<?php

class Routeur
{
    public function gererRequete()
    {
        // Récupère l'URL de la requête (par exemple, "/produit/42")
        $url = isset($_GET['url']) ? $_GET['url'] : '/';

        // Découpe l'URL pour obtenir le contrôleur et l'action
        $urlParts = explode('/', trim($url, '/'));

        // Définir le contrôleur et l'action par défaut
        $controleurNom = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'tenracController';
        $action = isset($urlParts[1]) ? $urlParts[1] : 'index';

        // Charger le contrôleur et exécuter l'action
        if (file_exists("controllers/$controleurNom.php")) {
            require_once "controllers/$controleurNom.php";
            $controleur = new $controleurNom();
            if (method_exists($controleur, $action)) {
                $controleur->$action();
            } else {
                echo "Action $action non trouvée dans le contrôleur $controleurNom";
            }
        } else {
            echo "Contrôleur $controleurNom non trouvé";
        }
    }
}
