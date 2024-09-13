<!DOCTYPE html>
<html>
<header>
<img url="./favicon.ico">
</header>
<head>
    <title>Gestion des Repas</title>
    <style>
        .plat {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .plat h4 {
            margin: 0;
            font-size: 1.5em;
        }
        .plat p {
            margin: 5px 0;
        }
        .club {
            margin-bottom: 30px;
        }
        .button-container {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
    </style>
    <script>
        let participants = <?= isset($repas['participants']) ? $repas['participants'] : 0 ?>;
        let selectedPlats = {};

        function ajouterPlat(platId) {
            if (!selectedPlats[platId]) {
                selectedPlats[platId] = 0;
            }

            let totalPlats = Object.values(selectedPlats).reduce((acc, val) => acc + val, 0);

            if (totalPlats < participants) {
                selectedPlats[platId]++;
                document.getElementById('quantity-' + platId).innerText = selectedPlats[platId];
            } else {
                alert("Le nombre total de plats ne peut pas dépasser le nombre de participants.");
            }
        }

        function enleverPlat(platId) {
            if (selectedPlats[platId] && selectedPlats[platId] > 0) {
                selectedPlats[platId]--;
                document.getElementById('quantity-' + platId).innerText = selectedPlats[platId];
            }
        }

        function verifierParticipants() {
            let totalPlats = Object.values(selectedPlats).reduce((acc, val) => acc + val, 0);
            if (totalPlats !== participants) {
                alert("Le nombre total de plats doit être égal au nombre de participants.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <h1>Gestion des Repas</h1>

    <!-- Formulaire pour ajouter ou modifier un repas -->
    <form action="/repas/sauvegarder" method="POST" onsubmit="return verifierParticipants();">
        <input type="hidden" name="id" value="<?= isset($repas['id']) ? $repas['id'] : '' ?>">

        <label>Club :</label>
        <select name="club_id" id="club-select" required>
            <option value="">Sélectionnez un club</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= $club['id'] ?>" <?= isset($repas['club_id']) && $repas['club_id'] == $club['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($club['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Date :</label>
        <input type="date" name="date" value="<?= isset($repas['date']) ? htmlspecialchars($repas['date']) : '' ?>" required><br>

        <label>Participants :</label>
        <input type="number" id="participants" name="participants" value="<?= isset($repas['participants']) ? htmlspecialchars($repas['participants']) : '' ?>" required><br>

        <h2>Sélectionnez les plats (en fonction des participants)</h2>
        <div id="plats-container">
            <!-- Vérifier si des plats sont disponibles -->
            <?php if (!empty($plats) && is_array($plats)): ?>
                <?php foreach ($plats as $plat): ?>
                    <div class="plat">
                        <h4><?= htmlspecialchars($plat['nom']) ?></h4>
                        <p><strong>Ingrédients :</strong> <?= htmlspecialchars($plat['ingredients']) ?></p>
                        <div class="button-container">
                            <button type="button" class="sub-plat" onclick="enleverPlat(<?= $plat['id'] ?>)">-</button>
                            <span id="quantity-<?= $plat['id'] ?>">0</span>
                            <button type="button" class="add-plat" onclick="ajouterPlat(<?= $plat['id'] ?>)">+</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun plat disponible pour ce club.</p>
            <?php endif; ?>
        </div>

        <button type="submit">Sauvegarder</button>
    </form>

    <!-- Liste des repas existants -->
    <h2>Repas existants</h2>
    <ul>
        <?php if (isset($repasList) && is_array($repasList)): ?>
            <?php foreach ($repasList as $repasItem): ?>
                <li>
                    <p>Club : <?= htmlspecialchars($repasItem['club_nom'] ?? 'N/A') ?></p>
                    <p>Date : <?= isset($repasItem['date']) ? date('d/m/Y', strtotime($repasItem['date'])) : 'N/A' ?></p>
                    <p>Participants : <?= htmlspecialchars($repasItem['participants'] ?? 'N/A') ?></p>
                    <p>Plats : <?= htmlspecialchars($repasItem['plats'] ?? 'N/A') ?></p>
                    <a href="/repas/editer/<?= $repasItem['id'] ?>">Modifier</a> | 
                    <a href="/repas/supprimer/<?= $repasItem['id'] ?>">Supprimer</a>
                </li>
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