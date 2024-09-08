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
<html>

<head>
    <title>Connexion</title>
</head>

<body>
    <h1>Connexion</h1>

    <!-- Formulaire de connexion -->
    <form action="/tenrac/connecter" method="POST">
        <label>Id :</label>
        <input type="text" name="id" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
    <a href='/tenrac/deconnecter'>Se déconnecter</a>
</body>

</html>