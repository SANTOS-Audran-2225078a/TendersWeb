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
        <button type="submit">Sauvegarder</button>
    </form>

    <!-- Liste des plats existants -->
    <h2>Plats existants</h2>
    <ul>
        <?php foreach ($plats as $plat): ?>
            <li class="plat">
                <h3><?= htmlspecialchars($plat['nom']) ?></h3>
                <p><strong>Ingrédients :</strong> <?= htmlspecialchars($plat['ingredients'] ?? '') ?></p>
                <p class="risque"><strong>Aliments à risque :</strong> <?= htmlspecialchars($plat['aliment_a_risque'] ?? '') ?></p>
                <a href="/plat/editer/<?= $plat['id'] ?>">Modifier</a> | 
                <a href="/plat/supprimer/<?= $plat['id'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/acceuil">
        <button>Retour à l'Accueil</button>
    </a>

</body>
</html>