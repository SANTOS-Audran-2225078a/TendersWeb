<!DOCTYPE html>
<html>

<head>
    <title>Modifier un Plat</title>
    <img url="../favicon.ico" alt="Un petit poulet gardant un vieux fromage...">
</head>

<body>
    <h1>Modifier un Plat</h1>

    <form action="/plat/modifierPlat" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($plat['id']) ?>">

        <label>Nom du plat :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($plat['nom']) ?>" required><br>

        <label>Ingrédients :</label>
        <div id="ingredients-container">
            <?php foreach ($plat['ingredients'] as $ingredient): ?>
                <div class="ingredient-row">
                    <select name="ingredient_ids[]" required>
                        <option value="">Sélectionnez un ingrédient</option>
                        <?php if (isset($ingredients)) {
                            foreach ($ingredients as $ingr): ?>
                                <option value="<?= htmlspecialchars($ingr['id']) ?>" <?= $ingr['id'] == $ingredient['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ingr['nom']) ?>
                                </option>
                            <?php endforeach;
                        } ?>
                    </select>
                    <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="ajouterIngredient()">Ajouter un ingrédient</button><br>

        <label>Club :</label>
        <select name="club_id" required>
            <?php if (isset($clubs)) {
                foreach ($clubs as $club): ?>
                    <option value="<?= htmlspecialchars($club['id']) ?>" <?= $club['id'] == $plat['club_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($club['nom']) ?>
                    </option>
                <?php endforeach;
            } ?>
        </select><br>

        <button type="submit">Modifier</button>
    </form>

    <script>        
        /**
         * ajouterIngredient
         *
         * @return void
         */
        function ajouterIngredient() {
            var container = document.getElementById('ingredients-container');
            var newRow = document.createElement('div');
            newRow.classList.add('ingredient-row');
            newRow.innerHTML = `
                <select name="ingredient_ids[]" required>
                    <option value="">Sélectionnez un ingrédient</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                                        <option value="<?= htmlspecialchars($ingredient['id']) ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
            `;
            container.appendChild(newRow);
        }
        
        /**
         * supprimerIngredient
         *
         * @return void
         */
        function supprimerIngredient(button) {
            var row = button.parentElement;
            row.remove();
        }
    </script>
</body>

</html>