<!DOCTYPE html>
<html><header>
<img url="./favicon.ico">
</header>
<head>
    <title>Gestion des Clubs</title>
    <meta name="description" content="Vous êtes ici sur la page qui vous permez de consulter les différents clubs,
     vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
</head>
<body>
<header> 
        <!-- Bouton pour accéder à l'accueil' -->
        <a href="../views/accueil.php">
            <button>Accueil</button>
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

    <h1>Gestion des Clubs</h1>
<div class="boxForm">
    <!-- Formulaire pour ajouter ou modifier un club -->
    <?= isset($isEditing) && $isEditing ? 'Modifier le Club' : 'Ajouter un Club' ?>
    <form action="/club/sauvegarder" method="POST">
        <input type="hidden" name="id" value="<?= isset($club['id']) ? $club['id'] : '' ?>">
        <label>Nom du club :</label>
        <input type="text" name="nom" value="<?= isset($club['nom']) ? htmlspecialchars($club['nom']) : '' ?>" required><br>
        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= isset($club['adresse']) ? htmlspecialchars($club['adresse']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
    </form>
</div>
<div class="box">
    <!-- Liste des clubs existants -->
    <h2>Clubs existants</h2>
    <ul>
        <?php if (isset($clubs)) {
            foreach ($clubs as $club): ?>
                <li>
                    <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
                    <a href="/club/editer/<?= $club['id'] ?>">Modifier</a> |
                    <a href="/club/supprimer/<?= $club['id'] ?>">Supprimer</a>
                </li>
            <?php endforeach;
        } ?>
    </ul>
    </div>
    <!-- Bouton Retour à l'accueil -->
    <!--<a href="/tenrac/accueil">
        <button>Retour à l'Accueil</button>
    </a>-->

</body>
</html>  