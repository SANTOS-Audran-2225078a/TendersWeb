<!DOCTYPE html>
<html>

<head>
    <title>Gestion des Plats</title>
    <link rel="stylesheet" type="text/css" href="/style/gestion_plat.css">


</head>

<body>
    <h1>Gestion des Plats</h1>
    <!-- Formulaire pour ajouter ou modifier un plat -->
    <h2>Ajouter un Plat</h2>
    <form action="/plat/ajouterPlat" method="POST"><label>Nom du plat :</label><input type="text" name="nom" value=""
            required><br><label>Ingrédients :</label>
        <div id="ingredients-container">
            <div class="ingredient-row"><select name="ingredient_ids[]" required>
                    <option value="">Sélectionnez un ingrédient</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                    <?php endforeach; ?>
                </select><button type="button" onclick="supprimerIngredient(this)">Supprimer</button></div>
        </div><button type="button" onclick="ajouterIngredient()">Ajouter un ingrédient</button><br><label>Club
            :</label><select name="club_id" required>
            <option value="">Sélectionnez un club</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= $club['id'] ?>"><?= htmlspecialchars($club['nom']) ?></option>
            <?php endforeach; ?>
        </select><br><button type="submit">Ajouter</button>
    </form><a href="/tenrac/acceuil">Retour à l'accueil</a>

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
                                <?php foreach ($plat['ingredients'] as $ingredient): ?>
                                    <span class="<?= $ingredient['risque'] ? 'ingredient-risque' : '' ?>">
                                        <?= htmlspecialchars($ingredient['nom']) ?>
                                    </span>,
                                <?php endforeach; ?>
                            </p><a href="/plat/editer/<?= $plat['id'] ?>">Modifier</a>
                            <a href="/plat/supprimer/<?= $plat['id'] ?>">Supprimer</a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucun plat trouvé pour ce club</li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endforeach; ?>

    <script>function ajouterIngredient() {
            var container = document.getElementById('ingredients-container');
            var newRow = document.createElement('div');
            newRow.classList.add('ingredient-row');
            newRow.innerHTML = ` <select name="ingredient_ids[]" required><option value="">Sélectionnez un ingrédient</option>
            <?php foreach ($ingredients as $ingredient): ?><option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
            <?php endforeach; ?>
            </select><button type="button" onclick="supprimerIngredient(this)">Supprimer</button>`;
            container.appendChild(newRow);
        }

        function supprimerIngredient(button) {
            var row = button.parentElement;
            row.remove();
        }

    </script>
</body>

</html>