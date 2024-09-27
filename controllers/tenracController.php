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

        // Récupère le tenrac par le nom
        $tenracModel = new TenracModel();
        $tenrac = $tenracModel->verifierTenrac($nom);

        // Ajout de logs pour débogage (facultatif, peut être supprimé en production)
        var_dump('Mot de passe reçu : ' . $motDePasse);
        var_dump('Mot de passe haché stocké : ' . $tenrac['password']);

        // Vérification du hachage du mot de passe
        if ($tenrac && password_verify($motDePasse, $tenrac['password'])) {
            // Si le mot de passe est correct, démarrer une session
            if (session_status() === PHP_SESSION_NONE) {
                session_start(); // Démarre la session si elle n'est pas encore démarrée
            }
            $_SESSION['tenrac'] = $tenrac; // Stocke l'utilisateur dans la session

            // Redirection vers la page d'accueil après connexion réussie
            header('Location: /views/accueil.php');
            exit();
        } else {
            // Si la vérification échoue, afficher un message d'erreur
            var_dump('Mot de passe incorrect ou utilisateur non trouvé.');
            $messageErreur = "Identifiant ou mot de passe incorrect.";
            require_once 'views/login.php'; // Affiche la page de connexion avec le message d'erreur
        }
    } else {
        // Si la méthode n'est pas POST, afficher la page de connexion
        require_once 'views/login.php';
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
    if (isset($_POST['nom'], $_POST['adresse'], $_POST['email'], $_POST['tel'], $_POST['grade'], $_POST['rang'], $_POST['titre'], $_POST['dignite'])) {
        
        if (!empty($_POST['club_id']) && !empty($_POST['ordre_id'])) {
            echo 'Erreur : Vous ne pouvez pas sélectionner à la fois un club et un ordre.';
            return;
        }

        $tenracModel = new TenracModel();
        $tenracData = [
            'nom' => $_POST['nom'],
            'adresse' => $_POST['adresse'],
            'email' => $_POST['email'],
            'tel' => $_POST['tel'],
            'club_id' => !empty($_POST['club_id']) ? $_POST['club_id'] : null,
            'ordre_id' => !empty($_POST['ordre_id']) ? $_POST['ordre_id'] : null,
            'grade' => $_POST['grade'],
            'rang' => $_POST['rang'],
            'titre' => $_POST['titre'],
            'dignite' => $_POST['dignite']
        ];

        // Si le mot de passe est fourni, on le hache et on l'ajoute aux données
        if (!empty($_POST['password'])) {
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $tenracData['password'] = $passwordHash;
        }

        if (isset($_POST['id']) && $_POST['id'] !== '') {
            // Mode édition
            $tenracModel->modifierTenrac($_POST['id'], $tenracData);
        } else {
            // Ajout d'un nouveau tenrac
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

        // Validation de l'email avec filter_var
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Email invalide';
            return;
        }

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
            <a href='https://thelu.alwaysdata.net/tenrac/valider?code=$codeSecurite'>Valider mon inscription</a>";
        $mail->AltBody = "Cliquez sur ce lien pour valider votre inscription : 
            https://thelu.alwaysdata.net/tenrac/valider?code=$codeSecurite";  // Version texte (au cas où HTML est désactivé)

        // Envoyer l'email
        $mail->send();
        echo 'Un email avec un lien de validation vous a été envoyé.';
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
}


public function valider(string $code): void
{
    $tenracModel = new TenracModel();
    $tenrac = $tenracModel->verifierCodeSecurite($code);

    if ($tenrac) {
        // Redirige vers la page de création de mot de passe si le code est valide et non expiré
        header('Location: /tenrac/creerMotDePasse?id=' . $tenrac['id']);
        exit();
    } else {
        echo 'Code de validation incorrect ou expiré.';
    }
}







public function creerMotDePasse(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['confirm_password'], $_POST['id'])) {
        
        // Vérification que le mot de passe fait au moins 8 caractères
        if (strlen($_POST['password']) < 8) {
            echo 'Le mot de passe doit contenir au moins 8 caractères.';
            return;
        }

        // Vérification de correspondance entre les deux champs
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



public function resetPassword(int $id, string $nouveauMotDePasse): void
{
    $tenracModel = new TenracModel();
    $passwordHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

    // Met à jour le mot de passe pour l'utilisateur avec cet ID
    $tenracModel->definirMotDePasse($id, $passwordHash);

    echo "Mot de passe réinitialisé avec succès.";
}



}
