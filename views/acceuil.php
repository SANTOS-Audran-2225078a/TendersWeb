<?php

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
    <header>
        <img url="./favicon.ico">
    </header>

<head>
    <title>Accueil</title>
    <meta name="description" content="Vous êtes ici sur LE site des tenrac. Vous y trouverez des informations sur les différents clubs, 
    les plats et les repas. VOus pourrez aussi en rajouter.">
    <link rel="stylesheet" href="../_assets/styles/stylesheet_accueil.css">
</head>

<body>
    <header>
        <h1>Bienvenue, <?= htmlspecialchars($tenrac['nom']) ?> !</h1>

        <!-- Bouton pour accéder à la gestion des clubs -->
        <a href="/club">
            <button>Gérer les Clubs</button>
        </a>

        <!-- Bouton pour accéder à la gestion des plats -->
        <a href="/plat">
            <button>Gérer les Plats</button>
        </a>

        <!-- Bouton pour accéder à la gestion des repas -->
        <a href="/repas">
            <button>Gérer les Repas</button>
        </a>

        <!-- Bouton pour accéder à ses infos personnelles-->
        <a href="/tenrac">
            <button>Les tenrac</button>
        </a>

        <!-- Bouton de déconnexion -->
        <a href='/tenrac/deconnecter'>Se déconnecter</a>
    </header>
<section class="Liste">
    <div>
        <p>Bienvenue sur LE site Tenrac. Ici vous pourrez retrouver toutes les informations que vous voudrez sur notre communauté !
        Que ce soit nos clubs, nos repas, nos plats ou encore les différents tenracs qui composent notre communauté</p>
    </div>

    <div>
        <p> Ici vous pouvez observer un exemple de plat que vous pourrez trouver sur notre site.</p>
    </div>
<section>
</body>

</html>