<?php

require_once 'models/tenracModel.php';
require_once 'models/clubModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../vendor/autoload.php';


class tenracController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) { 
            session_start(); // Vérifie si une session est active
        }

        if (isset($_SESSION['tenrac'])) {
            require_once 'views/accueil.php'; // Affiche la page de gestion des tenracs
        } else {
            require_once 'views/login.php'; // Si non connecté, redirige vers la page de connexion
        } 
    }

    public function index2(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Vérifie si une session est active
        }

        if (isset($_SESSION['tenrac'])) {
            $tenracModel = new TenracModel();
            $tenracs = $tenracModel->getAllTenracs(); // Récupère tous les tenracs

            $clubModel = new ClubModel();
            $clubs = $clubModel->getAllClubs(); // Récupère tous les clubs

            require_once 'views/tenrac/gestion_tenrac.php'; // Affiche la page de gestion des tenracs
        } else {
            require_once 'views/login.php';
        } 
    }

    public function connecter(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $motDePasse = $_POST['password'];

        // Récupère le tenrac par le nom, sans inclure le mot de passe dans la requête
        $tenracModel = new TenracModel();
        $tenrac = $tenracModel->verifierTenrac($nom);

        // Vérification avec password_verify
        if ($tenrac && password_verify($motDePasse, $tenrac['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start(); // Démarre la session si elle n'est pas déjà démarrée
            }

            // Stocke l'utilisateur dans la session
            $_SESSION['tenrac'] = $tenrac;

            header('Location: /tenrac/accueil');
            exit();
        } else {
            $messageErreur = "Identifiant ou mot de passe incorrect.";
            require_once 'views/login.php';
        }
    }
}


    public function accueil(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session si elle n'est pas déjà démarrée
        }

        if (isset($_SESSION['tenrac'])) {
            $tenrac = $_SESSION['tenrac'];
            require_once 'views/accueil.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function deconnecter(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session uniquement si elle n'est pas déjà démarrée
        }

        session_destroy();
        header('Location: /');
        exit();
    }

    // Méthode pour sauvegarder un Tenrac (ajout ou modification)
    // Enregistrer un nouveau repas
    public function sauvegarder(): void
{
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['email'], $_POST['password'], $_POST['tel'], $_POST['grade'], $_POST['rang'], $_POST['titre'], $_POST['dignite'])) {
        
        // Vérifier que l'utilisateur ne peut pas sélectionner un club et un ordre en même temps
        if (!empty($_POST['club_id']) && !empty($_POST['ordre_id'])) {
            echo 'Erreur : Vous ne pouvez pas sélectionner à la fois un club et un ordre.';
            return;
        }

        $tenracModel = new TenracModel();
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

        $tenracData = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'email' => $_POST['email'],
            'password' => $passwordHash,
            'tel' => $_POST['tel'],
            'club_id' => !empty($_POST['club_id']) ? $_POST['club_id'] : null,
            'ordre_id' => !empty($_POST['ordre_id']) ? $_POST['ordre_id'] : null,
            'grade' => $_POST['grade'],
            'rang' => $_POST['rang'],
            'titre' => $_POST['titre'],
            'dignite' => $_POST['dignite']
        ];

        // Si on est en mode édition (id existant), on met à jour
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $tenracModel->modifierTenrac($_POST['id'], $tenracData);
        } else {
            // Sinon on ajoute un nouveau Tenrac
            $tenracModel->ajouterTenrac($tenracData);
        }

        header('Location: /tenrac');
        exit();
    } else {
        echo 'Formulaire incomplet'; 
    }
}

    

// Enregistrer les modifications d'un repas
public function modifier(): void
{
    if (isset($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $_POST['chef_de_rencontre'])) {
        $plats = isset($_POST['plats']) ? implode(',', $_POST['plats']) : null; // Plats non obligatoires
        $repasModel = new RepasModel();
        $repasModel->modifierRepas($_POST['id'], $_POST['nom'], $_POST['adresse'], $_POST['date'], $_POST['participants'], $plats, $_POST['chef_de_rencontre']);
        header('Location: /repas');
    } else {
        echo 'Formulaire incomplet';
    }
}



    // Méthode pour supprimer un Tenrac
    public function supprimer($id): void
    {
        if ($id) {
            $tenracModel = new TenracModel();
            $tenracModel->supprimerTenrac($id); // Appelle la méthode pour supprimer le Tenrac dans le modèle

            header('Location: /tenrac'); // Redirige vers la gestion des tenracs après suppression
            exit();
        } else {
            echo "ID non fourni pour la suppression.";
        }
    }

    public function editer(int $id): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Démarre la session si elle n'est pas déjà démarrée
    }

    if (isset($_SESSION['tenrac'])) {
        $tenracModel = new TenracModel();
        $tenrac = $tenracModel->getTenracById($id); // Récupère le tenrac par son ID

        if ($tenrac) {
            $clubModel = new ClubModel();
            $clubs = $clubModel->getAllClubs(); // Récupère tous les clubs pour afficher dans la liste déroulante

            // Affiche la page de gestion du tenrac avec les données à modifier
            require_once 'views/tenrac/gestion_tenrac.php';
        } else {
            echo "Aucun tenrac trouvé avec l'ID : " . $id;
        }
    } else {
        header('Location: /login');
        exit();
    }
}

public function inscrire(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tenracModel = new TenracModel();
        $email = $_POST['email'];

        // Vérifier si l'email est déjà utilisé
        if ($tenracModel->verifierEmail($email)) {
            echo 'Email déjà utilisé';
            return;
        }

        // Générer un code de sécurité aléatoire
        $codeSecurite = bin2hex(random_bytes(8));  // Code de 16 caractères
        $expiration = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $tenracData = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'email' => $email,
            'tel' => $_POST['tel'],
            'club_id' => $_POST['club_id'] ?? null,
            'ordre_id' => $_POST['ordre_id'] ?? null,
            'grade' => $_POST['grade'],
            'rang' => $_POST['rang'],
            'titre' => $_POST['titre'],
            'dignite' => $_POST['dignite'],
            'code_securite' => $codeSecurite,
            'expiration' => $expiration,
        ];

        // Sauvegarder le tenrac avec le code de sécurité
        $tenracModel->ajouterTenracTemporaire($tenracData);

        // Envoyer un email avec le code de sécurité
        $this->envoyerMail($email, $codeSecurite);

        echo 'Un email avec un lien de validation vous a été envoyé.';
    }
}

private function envoyerMail($email, $codeSecurite): void
{
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp-iut.alwaysdata.net';  // Serveur SMTP Alwaysdata
        $mail->SMTPAuth = true;
        $mail->Username = 'iut@alwaysdata.net';  // Adresse email Alwaysdata
        $mail->Password = 'tendrac123.';          // Mot de passe de ton adresse email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Type de chiffrement (STARTTLS recommandé)
        $mail->Port = 587;  // Port SMTP pour le chiffrement STARTTLS

        // Expéditeur
        $mail->setFrom('iut@alwaysdata.net', 'Tendrac Web');
        
        // Destinataire
        $mail->addAddress($email);  // L'adresse email du destinataire
        
        // Contenu de l'email
        $mail->isHTML(true);  // Format HTML 
        $mail->Subject = 'Votre code de validation';
        $mail->Body    = "Cliquez sur ce lien pour valider votre inscription : 
            <a href='http://https://thelu.alwaysdata.net/tenrac/valider?code=$codeSecurite'>Valider mon inscription</a>";
        $mail->AltBody = "Cliquez sur ce lien pour valider votre inscription : 
            http://votre-site.com/tenrac/valider?code=$codeSecurite";  // Version texte (au cas où HTML est désactivé)

        // Envoyer l'email
        $mail->send();
        echo 'Un email avec un lien de validation vous a été envoyé.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}


public function valider(): void
{
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $tenracModel = new TenracModel();

        // Vérifier le code de sécurité et l'expiration
        $tenrac = $tenracModel->verifierCodeSecurite($code);

        if ($tenrac && strtotime($tenrac['expiration']) > time()) {
            // Redirige vers la page de création de mot de passe
            header('Location: /tenrac/creerMotDePasse?id=' . $tenrac['id']);
        } else {
            echo 'Code de validation incorrect ou expiré.';
        }
    }
}


public function creerMotDePasse(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['confirm_password'], $_POST['id'])) {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $tenracModel = new TenracModel();
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la BD et valider l'inscription
            $tenracModel->definirMotDePasse($_POST['id'], $passwordHash);

            echo 'Mot de passe créé avec succès. Vous pouvez maintenant vous connecter.';
        } else {
            echo 'Les mots de passe ne correspondent pas.';
        }
    } else {
        require_once 'views/tenrac/creerMotDePasse.php';
    }
}


}
