<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Plats</title>
    <style>
        .plat {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .plat h3 {
            margin: 0;
            font-size: 1.5em;
        }
        .plat p {
            margin: 5px 0;
        }
        .club {
            margin-bottom: 30px;
        }
        .risque {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Gestion des Plats</h1>

    <!-- Formulaire pour ajouter ou modifier un plat -->
    <form action="/plat/sauvegarder" method="POST">
    <input type="hidden" name="id" value="<?= isset($plat['id']) ? $plat['id'] : '' ?>">
    <label>Nom du plat :</label>
    <input type="text" name="nom" value="<?= isset($plat['nom']) ? htmlspecialchars($plat['nom']) : '' ?>" required><br>
    <label>Ingrédients :</label>
    <textarea name="ingredients" required><?= isset($plat['ingredients']) ? htmlspecialchars($plat['ingredients']) : '' ?></textarea><br>
    <label>Aliments à risque :</label>
    <textarea name="aliment_a_risque" required><?= isset($plat['aliment_a_risque']) ? htmlspecialchars($plat['aliment_a_risque']) : '' ?></textarea><br>
    <label>Club :</label>
    <select name="club_id" required>
        <option value="">Sélectionnez un club</option>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= $club['id'] ?>" <?= isset($plat['club_id']) && $plat['club_id'] == $club['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($club['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Sauvegarder</button>
</form>



    <!-- Liste des plats existants par club -->
    <h2>Plats existants par club</h2>
<?php foreach ($clubs as $club): ?>
    <div class="club">
        <h3><?= htmlspecialchars($club['nom']) ?></h3>
        <ul>
            <?php if (!empty($platsParClub[$club['id']])): ?>
                <?php foreach ($platsParClub[$club['id']] as $plat): ?>
                    <li class="plat">
                        <h4><?= htmlspecialchars($plat['nom']) ?></h4>
                        <p><strong>Ingrédients :</strong> <?= htmlspecialchars($plat['ingredients']) ?></p>
                        <p class="risque"><strong>Aliments à risque :</strong> <?= htmlspecialchars($plat['aliment_a_risque']) ?></p>
                        <a href="/plat/editer/<?= $plat['id'] ?>">Modifier</a> | 
                        <a href="/plat/supprimer/<?= $plat['id'] ?>">Supprimer</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun plat pour ce club</li>
            <?php endif; ?>
        </ul>
    </div>
<?php endforeach; ?>


    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/acceuil">
        <button>Retour à l'Accueil</button>
    </a>

</body>
</html>
