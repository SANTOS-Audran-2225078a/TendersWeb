class tenracController
{
    // Afficher la liste des tenracs
    public function liste()
    {
        $tenracModel = new tenracModel();
        $tenracs = $tenracModel->getAllTenracs();
        require_once 'views/tenrac/liste.php'; // Créez cette vue pour afficher la liste
    }

    // Ajouter un nouveau tenrac
    public function ajouter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $adresse = $_POST['adresse'];
            $grade = $_POST['grade'];
            $ordre_id = $_POST['ordre_id'];
            $club_id = $_POST['club_id'];

            $tenracModel = new tenracModel();
            $tenracModel->addTenrac($nom, $email, $tel, $adresse, $grade, $ordre_id, $club_id);

            header('Location: /tenrac/liste'); // Redirige vers la liste des tenracs après ajout
            exit();
        } else {
            require_once 'views/tenrac/ajouter.php'; // Vue pour ajouter un tenrac
        }
    }

    // Modifier un tenrac
    public function modifier($id)
    {
        $tenracModel = new tenracModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $adresse = $_POST['adresse'];
            $grade = $_POST['grade'];
            $ordre_id = $_POST['ordre_id'];
            $club_id = $_POST['club_id'];

            $tenracModel->updateTenrac($id, $nom, $email, $tel, $adresse, $grade, $ordre_id, $club_id);

            header('Location: /tenrac/liste');
            exit();
        } else {
            $tenrac = $tenracModel->getTenracById($id); // Créez une méthode pour récupérer un tenrac par ID
            require_once 'views/tenrac/modifier.php';
        }
    }

    // Supprimer un tenrac
    public function supprimer($id)
    {
        $tenracModel = new tenracModel();
        $tenracModel->deleteTenrac($id);

        header('Location: /tenrac/liste');
        exit();
    }
}
