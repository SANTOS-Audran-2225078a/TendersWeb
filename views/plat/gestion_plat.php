<!DOCTYPE html>
<html>
<head>
    <title><?= isset($plat) ? 'Modifier un Plat' : 'Ajouter un Plat' ?></title>
    <meta name="description" content="Vous êtes ici sur la page qui vous permez de consulter les différents plats,
     vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="../_assets/styles/stylesheet_accueil.css">
</head>
<body>
<header>
        <!-- Bouton pour accéder à l'accueil' -->
        <a href="../views/acceuil.php">
            <button>Accueil</button>
        </a>

        <!-- Bouton pour accéder à la gestion des plats -->
        <a href="/club">
            <button>Gérer les Clubs</button>
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

    <h1><?= isset($plat) ? 'Modifier un Plat' : 'Ajouter un Plat' ?></h1>

    <!-- Formulaire pour ajouter ou modifier un plat -->
    <form action="<?= isset($plat) ? '/plat/modifierPlat' : '/plat/ajouterPlat' ?>" method="POST" class="box">
        <?php if (isset($plat)): ?>
            <input type="hidden" name="id" value="<?= $plat['id'] ?>">
        <?php endif; ?>

        <label>Nom du plat :</label>
        <input type="text" name="nom" value="<?= isset($plat['nom']) ? htmlspecialchars($plat['nom']) : '' ?>" required><br>

        <label>Club :</label>
        <select name="club_id" required>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= $club['id'] ?>" <?= isset($plat) && $club['id'] == $plat['club_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($club['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Ingrédients :</label>
        <div id="ingredients-container">
            <?php if (isset($plat['ingredients'])): ?>
                <!-- Modifier un plat : afficher les ingrédients existants -->
                <?php foreach ($plat['ingredients'] as $ingredient): ?>
                    <div class="ingredient-row">
                        <select name="ingredient_ids[]">
                            <option value="">Sélectionnez un ingrédient</option>
                            <?php foreach ($ingredients as $ing): ?>
                                <option value="<?= $ing['id'] ?>" <?= $ing['id'] == $ingredient['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ing['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Ajouter un nouveau plat : champ pour sélectionner des ingrédients -->
                <div class="ingredient-row">
                    <select name="ingredient_ids[]" required>
                        <option value="">Sélectionnez un ingrédient</option>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="supprimerIngredient(this)">Supprimer</button>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" onclick="ajouterIngredient()">Ajouter un ingrédient</button><br>

        <button type="submit"><?= isset($plat) ? 'Modifier' : 'Ajouter' ?></button>
    </form>

    <!-- Liste des plats existants par club -->
    <!-- Liste des plats existants par club -->
<h2>Plats par Club</h2>
<div class="Liste">
<?php if (isset($plats) && is_array($plats)): ?>
    <?php foreach ($clubs as $club): ?>
        <div class="box">
        <h3><?= htmlspecialchars($club['nom']) ?></h3>
        <ul>
            <?php foreach ($plats as $plat): ?>
                <?php if ($plat['club_id'] == $club['id']): ?>
                    <li>
                        <?= htmlspecialchars($plat['nom']) ?>
                        <a href="/plat/editer/<?= $plat['id'] ?>">Modifier</a> | 
                        <a href="/plat/supprimer/<?= $plat['id'] ?>">Supprimer</a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <?php if (empty(array_filter($plats, fn($p) => $p['club_id'] == $club['id']))): ?>
            <p>Aucun plat pour ce club.</p>
        <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun plat trouvé.</p>
<?php endif; ?>
</div>


    <script>
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

        function supprimerIngredient(button) {
            var row = button.parentElement;
            row.remove();
        }
    </script>
</body>
</html>
