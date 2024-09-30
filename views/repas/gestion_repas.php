<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des Repas</title>
    <script>
        // Fonction pour charger les plats en fonction du club sélectionné
        function chargerPlatsParClub(clubId) {
            fetch('/repas/getPlatsByClub/' + clubId)
                .then(response => response.json())
                .then(data => {
                    let platsContainer = document.getElementById('cartePlats');
                    platsContainer.innerHTML = ''; // Vider les plats affichés précédemment

                    data.forEach(function(plat) {
                        let platDiv = document.createElement('div');
                        platDiv.textContent = plat.nom;
                        platsContainer.appendChild(platDiv);
                    }); 
                });
        }
    </script>
    <meta name="description" content="Vous êtes ici sur la page qui vous permet de consulter les différents repas, 
    vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
</head>
<body>
<header>
    <div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="menu" id="menu">
    <!-- Bouton pour accéder à l'accueil' -->
    <a href="../views/accueil.php">
        <button>Accueil</button> 
    </a>

    <!-- Bouton pour accéder à la gestion des clubs -->
    <a href="/club">
        <button>Gérer les Clubs</button>
    </a>

    <!-- Bouton pour accéder à la gestion des repas -->
    <a href="/plat">
        <button>Gérer les Plats</button>
    </a>

    <!-- Bouton pour accéder à ses infos personnelles-->
    <a href="/tenrac">
        <button>Les tenrac</button>
    </a>

    <!-- Bouton de déconnexion -->
    <a href='/tenrac/deconnecter'>Se déconnecter</a>
    </nav>
</header>

<h1><?= isset($repas['id']) ? 'Modifier un Repas' : 'Ajouter un Repas' ?></h1>

<!-- Formulaire pour ajouter ou modifier un repas -->
<form action="<?= isset($repas['id']) ? '/repas/modifier' : '/repas/sauvegarder' ?>" method="POST" class="boxForm">
    <?php if (isset($repas['id'])): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($repas['id']) ?>">
    <?php endif; ?>

    <label>Nom du repas :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($repas['nom'] ?? '') ?>" required><br>

    <label>Adresse (Club) :</label>
    <select name="adresse" onchange="chargerPlatsParClub(this.value)" required>
        <option value="">Sélectionnez un club</option>
        <?php if (!empty($clubs)): ?>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= htmlspecialchars($club['id']) ?>" <?= isset($repas['adresse']) && $repas['adresse'] == $club['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">Aucun club disponible</option>
        <?php endif; ?>
    </select><br>

    <label>Date :</label>
    <input type="date" name="date" value="<?= htmlspecialchars($repas['date'] ?? '') ?>" required><br>

    <label>Participants :</label>
    <input type="number" name="participants" value="<?= htmlspecialchars($repas['participants'] ?? '') ?>" required><br>

    <label>Chef de rencontre :</label>
    <input type="text" name="chef_de_rencontre" value="<?= htmlspecialchars($repas['chef_de_rencontre'] ?? '') ?>" required><br>

    <label>Carte des plats :</label>
    <div id="cartePlats">
        <p>Sélectionnez un club pour voir les plats disponibles.</p>
    </div><br>

    <button type="submit"><?= isset($repas['id']) ? 'Modifier' : 'Ajouter' ?></button>
</form>

<!-- Liste des repas existants -->
<h2>Repas existants</h2>
<?php if (!empty($repas)): ?>
    <?php foreach ($repas as $r): ?>
        <div class="repas-container">
            <h3><?= htmlspecialchars($r['nom'] ?? 'Repas sans nom') ?></h3> <!-- Affiche uniquement le nom du repas -->
            <div class="repas-details">
                <p><strong>Date :</strong> <?= htmlspecialchars($r['date'] ?? '') ?></p>
                <p><strong>Participants :</strong> <?= htmlspecialchars($r['participants'] ?? '') ?></p>
                <p><strong>Chef de rencontre :</strong> <?= htmlspecialchars($r['chef_de_rencontre'] ?? '') ?></p>
                <p><strong>Adresse (Club) :</strong> <?= htmlspecialchars($r['club_nom'] ?? '') ?></p>
            </div>
            <div class="repas-actions">
                <a href="/repas/editer/<?= htmlspecialchars($r['id']) ?>">Modifier</a>
                <a href="/repas/supprimer/<?= htmlspecialchars($r['id']) ?>">Supprimer</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun repas disponible.</p>
<?php endif; ?>

<script>
    document.getElementById('burgerMenu').addEventListener('click', function () {
        var menu = document.getElementById('menu');
        menu.classList.toggle('active');
    });
</script>

</body>
</html> 
 