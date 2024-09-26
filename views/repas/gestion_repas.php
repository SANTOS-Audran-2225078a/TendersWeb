<!DOCTYPE html>
<html>
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
    <meta name="description" content="Vous êtes ici sur la page qui vous permez de consulter les différents repas,
    vous pourrez aussi en rajouter, les modifier ou en supprimer.">
    <link rel="stylesheet" href="../_assets/styles/stylesheet_accueil.css">
</head>
<body>
<header>
        <!-- Bouton pour accéder à l'accueil' -->
        <a href="../views/accueil.php">
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
    <h1>Gestion des Repas</h1>

    <!-- Formulaire pour ajouter un nouveau repas -->
    <form action="/repas/sauvegarder" method="POST">
        <?php if (isset($repas['id'])): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($repas['id']) ?>">
        <?php endif; ?>
    <div class="box">
        <label>Adresse (Club) :</label>
        <select name="adresse" onchange="chargerPlatsParClub(this.value)" required>

            <option value="">Sélectionnez un club</option>
            <?php if (!empty($clubs)): ?>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= htmlspecialchars($club['id']) ?>" <?= isset($repas['club_id']) && $repas['club_id'] == $club['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Aucun club disponible</option>
            <?php endif; ?>
        </select><br>

        <label>Date :</label>
        <input type="date" name="date" value="<?= isset($repas['date']) ? htmlspecialchars($repas['date']) : '' ?>" required><br>

        <label>Participants :</label>
        <input type="number" name="participants" value="<?= isset($repas['participants']) ? htmlspecialchars($repas['participants']) : '' ?>" required><br>

        <label>Chef de rencontre :</label>
        <input type="text" name="chef_de_rencontre" value="<?= isset($repas['chef_de_rencontre']) ? htmlspecialchars($repas['chef_de_rencontre']) : '' ?>" required><br>

        <label>Carte des plats :</label>
        <div id="cartePlats">
            <p>Sélectionnez un club pour voir les plats disponibles.</p>
        </div><br>

        <button type="submit">Ajouter</button>
    </div>
    </form>

    <!-- Liste des repas existants -->
    <h2>Repas existants</h2>
        <?php foreach ($repas as $r): ?>
            <div class="repas-container">
                <h3>Repas #<?= htmlspecialchars($r['id']) ?></h3>
                <div class="repas-details">
                    <p><strong>Date :</strong> <?= htmlspecialchars($r['date']) ?></p>
                    <p><strong>Participants :</strong> <?= htmlspecialchars($r['participants']) ?></p>
                    <p><strong>Chef de rencontre :</strong> <?= htmlspecialchars($r['chef_de_rencontre']) ?></p>
                    <p><strong>Adresse (Club) :</strong> <?= htmlspecialchars($r['club_nom']) ?></p>
                </div>
                <div class="repas-actions">
                    <a href="/repas/editer/<?= $r['id'] ?>">Modifier</a>
                    <a href="/repas/supprimer/<?= $r['id'] ?>">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
</body>
</html>
