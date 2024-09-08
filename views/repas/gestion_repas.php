<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Repas</title>
</head>
<body>
    <h1>Gestion des Repas</h1>

    <!-- Formulaire pour ajouter ou modifier un repas -->
    <form action="/repas/sauvegarder" method="POST">
        <input type="hidden" name="id" value="<?= isset($repas['id']) ? $repas['id'] : '' ?>">
        <label>Nom du repas :</label>
        <input type="text" name="nom" value="<?= isset($repas['nom']) ? htmlspecialchars($repas['nom']) : '' ?>" required><br>
        <label>Date :</label>
        <input type="date" name="date" value="<?= isset($repas['date']) ? htmlspecialchars($repas['date']) : '' ?>" required><br>
        <label>Lieu :</label>
        <input type="text" name="lieu" value="<?= isset($repas['lieu']) ? htmlspecialchars($repas['lieu']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
    </form>

    <!-- Liste des repas existants -->
    <h2>Repas existants</h2>
    <ul>
        <?php foreach ($repasList as $repas): ?>
            <li>
                <?= htmlspecialchars($repas['nom']) ?> - <?= htmlspecialchars($repas['date']) ?> - <?= htmlspecialchars($repas['lieu']) ?>
                <a href="/repas/editer/<?= $repas['id'] ?>">Modifier</a> | 
                <a href="/repas/supprimer/<?= $repas['id'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
