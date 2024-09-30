<!DOCTYPE html>
<html lang="fr"><header>
<img url="./favicon.ico" alt="logo">
</header>
<head>
    <title>Gestion des Clubs</title>
    <meta name="description" content="Vous êtes ici sur la page qui vous permez de consulter les différents clubs,
     vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
</head>
<body>
<header> 
    <div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="menu" id="menu">
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
    </nav>
</header>

    <h1>Gestion des Clubs</h1>
<div class="boxForm">
    <!-- Formulaire pour ajouter ou modifier un club -->
    <?= isset($isEditing) && $isEditing ? 'Modifier le Club' : 'Ajouter un Club' ?>
    <form action="/club/sauvegarder" method="POST">
        <input type="hidden" name="id" value="<?= isset($club['id']) ? $club['id'] : '' ?>">
        <label for="nom">Nom du club :</label>
        <input id="nom" type="text" name="nom" value="<?= isset($club['nom']) ? htmlspecialchars($club['nom']) : '' ?>" required><br>
        <label for="adresse">Adresse :</label>
        <input id="adresse" type="text" name="adresse" value="<?= isset($club['adresse']) ? htmlspecialchars($club['adresse']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
    </form>
</div>
<h2>Clubs existants</h2>
<section class="Liste">
    <!-- Liste des clubs existants -->
    <ul>
        <?php if (isset($clubs)) {
            foreach ($clubs as $club): ?>
            <div class="box">
                <li>
                    <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
                    <a href="/club/editer/<?= $club['id'] ?>" class="button">Modifier</a> |
                    <a href="/club/supprimer/<?= $club['id'] ?>" class="button">Supprimer</a>
                </li>
            </div>
            <?php endforeach;
        } ?>
    </ul>
</section>

<script>
    document.getElementById('burgerMenu').addEventListener('click', function () {
        var menu = document.getElementById('menu');
        menu.classList.toggle('active');
    });
</script>

</body>
</html>  