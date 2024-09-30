<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Vérifie si une session est active avant de démarrer une nouvelle session
}

// Affiche le message d'erreur s'il existe
if (isset($messageErreur)) {
    echo "<p style='color: red;'>$messageErreur</p>";
}

// Si l'utilisateur est connecté
if (isset($_SESSION['tenrac'])) {
    echo "<p>Vous êtes déjà connecté en tant que " . $_SESSION['tenrac']['nom'] . ".</p>";
}

?> 
 
<!DOCTYPE html> 
<html lang="fr">
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="../_assets/styles/stylesheet_login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>

<body>
    <h1>Connexion</h1>

    <!-- Formulaire de connexion -->
    <form action="/tenrac/connecter" method="POST">
        <label for="nom">Nom :</label>
        <input id="nom" type="text" name="nom" required><br>

        <label for="password">Mot de passe :</label>
        <input id="password" type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
    <!--<a href='/tenrac/deconnecter'>Se déconnecter</a>
    <br>
    <a href='/test.php'>Accueil</a> -->
</body>

</html>