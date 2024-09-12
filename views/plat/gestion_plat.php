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
        <label>Nom du plat :</label>
        <input type="text" name="nom" value="<?= isset($plat['nom']) ? htmlspecialchars($plat['nom']) : '' ?>"
            required><br>

        <label>Ingrédients :</label>
        <div id="ingredients-container">
            <div class="ingredient-row">
                <select name="ingredient_ids[]" required>
                    <option value="">Sélectionnez un ingrédient</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
            </div>
        </div>
        <button type="button" onclick="ajouterIngredient()">Ajouter un ingrédient</button><br>

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

    <script>
        function ajouterIngredient() {
            var container = document.getElementById('ingredients-container');
            var newRow = document.createElement('div');
            newRow.classList.add('ingredient-row');
            newRow.innerHTML = `
        <select name="ingredient_ids[]" required>
            <option value="">Sélectionnez un ingrédient</option>
            <?php foreach ($ingredients as $ingredient): ?>
                                                                                <option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
    `;
            container.appendChild(newRow);
        }

        function supprimerIngredient(button) {
            var row = button.parentElement;
            row.remove();
        }
    </script>






    <!-- Afficher les plats existants par club -->
    <h2>Plats existants par club</h2>
    <?php foreach ($clubs as $club): ?>
        <div class="club">
            <h3><?= htmlspecialchars($club['nom']) ?></h3>
            <ul>
                <?php if (!empty($platsParClub[$club['id']])): ?>
                    <?php foreach ($platsParClub[$club['id']] as $plat): ?>
                        <li class="plat">
                            <h4><?= htmlspecialchars($plat['nom']) ?></h4>
                            <p><strong>Ingrédients :</strong>
                                <?php if (!empty($plat['ingredients'])): ?>
                                    <?php
                                    $ingredientCount = count($plat['ingredients']); // Compte le nombre d'ingrédients
                                    $i = 0;
                                    ?>
                                    <?php foreach ($plat['ingredients'] as $ingredient): ?>
                                        <span class="<?= $ingredient['risque'] ? 'risque' : '' ?>">
                                            <?= htmlspecialchars($ingredient['nom']); ?>
                                        </span>
                                        <?php if (++$i < $ingredientCount): // Si ce n'est pas le dernier ingrédient ?>
                                            ,
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    Aucun ingrédient
                                <?php endif; ?>
                            </p>
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