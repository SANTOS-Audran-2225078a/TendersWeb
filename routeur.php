<?php
class Routeur
{
    public function gererRequete()
    {
        // Vérifiez la méthode de la requête
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = isset($_GET['url']) ? $_GET['url'] : '/';

        // Découpe l'URL pour obtenir le contrôleur et l'action
        $urlParts = explode('/', trim($url, '/'));

        // Définir le contrôleur et l'action par défaut
        $controleurNom = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'tenracController';
        $action = isset($urlParts[1]) ? $urlParts[1] : 'index';

        // Déboguer le contrôleur et l'action
        echo "Contrôleur: " . $controleurNom . "<br>";
        echo "Action: " . $action . "<br>";
        echo "Session: " . var_dump($_SESSION) . "<br>";

        // Charger le contrôleur et exécuter l'action
        if (file_exists("controllers/$controleurNom.php")) {
            require_once "controllers/$controleurNom.php";
            $controleur = new $controleurNom();

            // Vérifiez si l'action est valide et existe
            if (method_exists($controleur, $action)) {
                // Vérifiez la méthode de la requête (GET/POST)
                if ($requestMethod === 'POST') {

                    $controleur->$action();
                } else {
                    // Pour les requêtes GET, vous pouvez appeler une autre méthode si nécessaire
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
