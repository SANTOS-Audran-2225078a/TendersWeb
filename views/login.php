<?php
session_start(); // Ajoutez ceci en haut de votre fichier PHP

// Affiche le message d'erreur s'il existe
if (isset($messageErreur)) {
    echo "<p style='color: red;'>$messageErreur</p>";
}

// Si l'utilisateur est connecté
if (isset($_SESSION['tenrac'])) {
    echo "<p>Vous êtes déjà connecté en tant que " . $_SESSION['tenrac']['nom'] . ".</p>";
    echo "<a href='/login/deconnecter'>Se déconnecter</a>";
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
    <form action="/ternac/connecter" method="POST">
        <label>Id :</label>
        <input type="id" name="id" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>
</body>

</html>