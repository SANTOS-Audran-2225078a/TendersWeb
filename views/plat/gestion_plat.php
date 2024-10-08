<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?= isset($plat) ? 'Modifier un Plat' : 'Ajouter un Plat' ?></title>
    <meta name="description" content="Vous êtes ici sur la page qui vous permet de consulter les différents plats, vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
</head>
<body>
<header>
<div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="menu" id="menu">
    <a href="../views/accueil.php"><button>Accueil</button></a>
    <a href="/club"><button>Gérer les Clubs</button></a>
    <a href="/repas"><button>Gérer les Repas</button></a>
    <a href="/tenrac"><button>Les tenrac</button></a>
    <a href='/tenrac/deconnecter'>Se déconnecter</a>
    </nav>  
</header>

<h1><?= isset($plat) ? 'Modifier un Plat' : 'Ajouter un Plat' ?></h1>



<!-- Formulaire pour ajouter ou modifier un plat -->
<form action="<?= isset($plat) ? '/plat/modifierPlat' : '/plat/ajouterPlat' ?>" method="POST" class="boxForm">
    <?php if (isset($plat)): ?>
        <input type="hidden" name="id" value="<?= $plat['id'] ?>">
    <?php endif; ?>
    <label for="nomPlat">Nom du plat :</label>
    <input id="nomPlat" type="text" name="nom" value="<?= isset($plat['nom']) ? htmlspecialchars($plat['nom']) : '' ?>" required><br>
    <label for="club">Club :</label>
    <select id="club" name="club_id" required>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= $club['id'] ?>" <?= isset($plat) && $club['id'] == $plat['club_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($club['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label for="ingredients">Ingrédients :</label>
    <div id="ingredients-container">
        <?php if (isset($plat['ingredients'])): ?>
            <?php foreach ($plat['ingredients'] as $ingredient): ?>
                <div class="ingredient-row">
                    <select id="ingredients" name="ingredient_ids[]">
                        <option value="">Sélectionnez un ingrédient</option>
                        <?php foreach ($ingredients as $ing): ?>
                            <option value="<?= $ing['id'] ?>" <?= $ing['id'] == $ingredient['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ing['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" onclick="supprimerIngredient(this)" class="butTel">Supprimer</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="ingredient-row">
                <select name="ingredient_ids[]" required>
                    <option value="">Sélectionnez un ingrédient</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <option value="<?= $ingredient['id'] ?>"><?= htmlspecialchars($ingredient['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="supprimerIngredient(this)" class="butTel">Supprimer</button>
            </div>
        <?php endif; ?>
    </div>
    <button type="button" onclick="ajouterIngredient()" class="butTel">Ajouter un ingrédient</button><br>
    
    <fieldset>
    <legend>Sauce</legend> <!-- Légende -->
    <label for="sauc">Choisissez :</label>
    <div id="sauces-container">
        <?php foreach ($sauces as $sauce): ?>
            <input id="sauc" type="checkbox" name="sauce_ids[]" value="<?= $sauce['id'] ?>"
                <?= isset($platSauces) && in_array($sauce['id'], array_column($platSauces, 'id')) ? 'checked' : '' ?>>
            <?= htmlspecialchars($sauce['nom']) ?><br>
        <?php endforeach; ?>
    </div><br>
    </fieldset>

    <button type="submit" class="butTel"><?= isset($plat) ? 'Modifier' : 'Ajouter' ?></button>
</form>
<!-- Liste des plats existants par club -->
<h2>Plats par Club</h2>

<!-- Champ de recherche dynamique -->
<div class="barreRech">
    <h2>Recherche de plats par ingrédients ou nom</h2>
    <label for="chercheIng">Rechercher un ingrédient ou un plat</label><br>
    <input id="chercheIng" type="text" id="search-input" placeholder="Rechercher un ingrédient ou un plat...">
</div>

<div class="Liste">
<?php if (isset($plats) && is_array($plats)): ?>
    <?php foreach ($clubs as $club): ?>
        <div class="box">
        <h3><?= htmlspecialchars($club['nom']) ?></h3>
        <ul class="plat-list">
            <?php foreach ($plats as $plat): ?>
                <?php if ($plat['club_id'] == $club['id']): ?>
                    <li class="plat" data-ingredients="<?= strtolower(implode(' ', array_column($platModel->getIngredientsByPlat($plat['id']), 'nom'))) ?>" data-plat-name="<?= strtolower(htmlspecialchars($plat['nom'])) ?>">
                        <?= htmlspecialchars($plat['nom']) ?>
                        <a href="/plat/editer/<?= $plat['id'] ?>" class="button">Modifier</a> | 
                        <a href="/plat/supprimer/<?= $plat['id'] ?>" class="button" >Supprimer</a>
                        <div class="ingredients-text">
                            Ingrédients : 
                            <?= !empty($platModel->getIngredientsByPlat($plat['id'])) ? implode(', ', array_map(fn($ing) => htmlspecialchars($ing['nom']), $platModel->getIngredientsByPlat($plat['id']))) : 'Aucun ingrédient' ?>
                        </div>
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
    // Recherche dynamique dans la liste des plats
    document.getElementById('chercheIng').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var plats = document.querySelectorAll('.plat');

        plats.forEach(function(plat) {
            var platName = plat.getAttribute('data-plat-name');
            var ingredients = plat.getAttribute('data-ingredients');

            if (platName.includes(searchQuery) || ingredients.includes(searchQuery)) {
                plat.style.display = 'list-item';
            } else {
                plat.style.display = 'none';
            }
        });
    });
    
    /**
     * Ajouter un nouvel ingrédient à la liste des ingrédients du plat
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
     * Supprimer un ingrédient de la liste
     */
    function supprimerIngredient(button) { 
        var row = button.parentElement;
        row.remove();
    }
</script>

<script>
    // Gestion du menu burger
    document.getElementById('burgerMenu').addEventListener('click', function () {
        var menu = document.getElementById('menu');
        menu.classList.toggle('active');
    });
</script>
</body>
</html>
