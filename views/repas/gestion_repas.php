<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Repas</title>
    <script>
        function chargerPlatsParClub(club_id) {
            if (club_id === '') {
                document.getElementById('plat-select').innerHTML = '<option value="">Sélectionnez un club d\'abord</option>';
                return;
            }
            
            // Requête Ajax pour charger les plats selon le club sélectionné
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/repas/getPlatsByClub/' + club_id, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var plats = JSON.parse(xhr.responseText);
                    var platSelect = document.getElementById('plat-select');
                    platSelect.innerHTML = ''; // Clear current options
                    plats.forEach(function (plat) {
                        var option = document.createElement('option');
                        option.value = plat.id;
                        option.textContent = plat.nom;
                        platSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <h1>Gestion des Repas</h1>

    <!-- Formulaire pour ajouter ou modifier un repas -->
    <form action="/repas/sauvegarder" method="POST" id="repas-form">
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
    
    <h3>Plats disponibles pour ce club :</h3>
    <div id="plats-container">
        <!-- Les plats disponibles seront chargés ici via JavaScript -->
    </div>
    
    <button type="submit">Sauvegarder</button>
</form>

<script>
    document.getElementById('club-select').addEventListener('change', function() {
        const clubId = this.value;
        if (clubId) {
            fetch(`/repas/getPlatsByClub/${clubId}`)
                .then(response => response.json())
                .then(plats => {
                    const platsContainer = document.getElementById('plats-container');
                    platsContainer.innerHTML = '';
                    plats.forEach(plat => {
                        platsContainer.innerHTML += `
                            <div>
                                <span>${plat.nom} - ${plat.ingredients} - ${plat.aliment_a_risque}</span>
                                <button type="button" class="add-plat" data-plat-id="${plat.id}">+</button>
                                <span class="plat-count" id="plat-count-${plat.id}">0</span>
                            </div>
                        `;
                    });
                });
        } else {
            document.getElementById('plats-container').innerHTML = '';
        }
    });

    // Gestion du nombre de plats à ajouter par rapport aux participants
    document.getElementById('plats-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('add-plat')) {
            const platId = event.target.getAttribute('data-plat-id');
            const countElement = document.getElementById('plat-count-' + platId);
            const participants = parseInt(document.getElementById('participants').value);
            let currentCount = parseInt(countElement.innerHTML);

            if (currentCount < participants) {
                currentCount++;
                countElement.innerHTML = currentCount;
            }
        }
    });
</script>


    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/acceuil">
        <button>Retour à l'Accueil</button>
    </a>
</body>
</html>
