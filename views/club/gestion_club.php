<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Clubs</title>
    <img url="../favicon.ico" alt="Un petit poulet gardant un vieux fromage...">
</head>
<body>
    <h1>Gestion des Clubs</h1>

    <!-- Formulaire pour ajouter ou modifier un club -->
    <form action="/club/sauvegarder" method="POST">
        <input type="hidden" name="id" value="<?= isset($club['id']) ? $club['id'] : '' ?>">
        <label>Nom du club :</label>
        <input type="text" name="nom" value="<?= isset($club['nom']) ? htmlspecialchars($club['nom']) : '' ?>" required><br>
        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= isset($club['adresse']) ? htmlspecialchars($club['adresse']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
    </form>

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

    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/acceuil">
        <button>Retour à l'Accueil</button>
    </a>

</body>
</html>