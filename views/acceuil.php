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
<head>
    <meta-description>Résumé de page web... Description si on veut.</meta-description>
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($tenrac['nom']) ?> !</h1>
    <p>Email: <?= htmlspecialchars($tenrac['email']) ?></p>
    <p>Téléphone: <?= htmlspecialchars($tenrac['tel']) ?></p>
    <p>Adresse: <?= htmlspecialchars($tenrac['adresse']) ?></p>
    <p>Grade: <?= htmlspecialchars($tenrac['grade']) ?></p>

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

    <!-- Bouton de déconnexion -->
    <a href='/tenrac/deconnecter'>Se déconnecter</a>


    <h2>Rendez-vous importants</h2>
<?php if (!empty($repasImportant)): ?>
    <ul>
        <?php foreach ($repasImportant as $repas): ?>
            <li>
                <strong>Club :</strong> <?= htmlspecialchars($repas['club_id']) ?><br>
                <strong>Date :</strong> <?= htmlspecialchars($repas['date']) ?><br>
                <strong>Participants :</strong> <?= htmlspecialchars($repas['participants']) ?><br>
                <strong>Plats :</strong> <?= htmlspecialchars($repas['plats']) ?><br>
                <strong>Adresse :</strong> <?= htmlspecialchars($repas['adresse']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun repas à venir.</p>
<?php endif; ?>

</body>
</html>