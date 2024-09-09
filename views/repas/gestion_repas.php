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
        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= isset($repas['adresse']) ? htmlspecialchars($repas['adresse']) : '' ?>" required><br>
        <label>Date :</label>
        <input type="date" name="date" value="<?= isset($repas['date']) ? htmlspecialchars($repas['date']) : '' ?>" required><br>
        <label>Participants :</label>
        <input type="number" name="participants" value="<?= isset($repas['participants']) ? htmlspecialchars($repas['participants']) : '' ?>" required><br>
        <label>Plats :</label>
        <input type="text" name="plats" value="<?= isset($repas['plats']) ? htmlspecialchars($repas['plats']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
    </form>

    <!-- Liste des repas existants -->
    <h2>Repas existants</h2>
    <ul>
        <?php if (isset($repas) && is_array($repas)): ?>
            <?php foreach ($repas as $repasItem): ?>
                <?php if (is_array($repasItem)): ?>
                    <li>
                        <p>Adresse : <?= htmlspecialchars($repasItem['adresse'] ?? 'N/A') ?></p>
                        <p>Date : <?= isset($repasItem['date']) ? date('d/m/Y', strtotime($repasItem['date'])) : 'N/A' ?></p>
                        <p>Participants : <?= htmlspecialchars($repasItem['participants'] ?? 'N/A') ?></p>
                        <p>Plats : <?= htmlspecialchars($repasItem['plats'] ?? 'N/A') ?></p>
                        <a href="/repas/editer/<?= $repasItem['id'] ?>">Modifier</a> | 
                        <a href="/repas/supprimer/<?= $repasItem['id'] ?>">Supprimer</a>
                    </li>
                <?php else: ?>
                    <li>Erreur : données de repas invalides.</li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun repas trouvé.</p>
        <?php endif; ?>
    </ul>

    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/acceuil">
        <button>Retour à l'Accueil</button>
    </a>

</body>
</html>