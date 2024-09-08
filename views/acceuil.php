<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['tenrac'])) {
    $tenrac = $_SESSION['tenrac'];
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
</head>

<body>
    <h1>Bienvenue, <?= htmlspecialchars($tenrac['nom']) ?> !</h1>
    <p>Email: <?= htmlspecialchars($tenrac['email']) ?></p>
    <p>Téléphone: <?= htmlspecialchars($tenrac['tel']) ?></p>
    <p>Adresse: <?= htmlspecialchars($tenrac['adresse']) ?></p>
    <p>Grade: <?= htmlspecialchars($tenrac['grade']) ?></p>
    <a href='/tenrac/deconnecter'>Se déconnecter</a>
</body>

</html>