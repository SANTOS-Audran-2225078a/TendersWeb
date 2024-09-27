<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Tenracs</title>
    <meta name="description" content="Vous êtes ici sur LE site des tenracs. Vous y trouverez des informations sur les différents clubs, 
    les plats et les repas. Vous pourrez aussi en rajouter.">
    <link rel="stylesheet" href="../_assets/styles/stylesheet_accueil.css">
    <script>
        // Désactive la sélection de club si "Oui" est sélectionné pour l'ordre et inversement
        function checkSelection() {
            const clubSelect = document.querySelector('select[name="club_id"]');
            const ordreSelect = document.querySelector('select[name="ordre_id"]');

            // Si un club est sélectionné, désactive l'option "Oui" dans l'ordre
            clubSelect.addEventListener('change', function() {
                if (clubSelect.value !== '') {
                    ordreSelect.value = ""; // Réinitialiser l'ordre si un club est sélectionné
                    ordreSelect.disabled = true; // Désactiver l'ordre
                } else {
                    ordreSelect.disabled = false; // Réactiver l'ordre si aucun club sélectionné
                }
            });

            // Si "Oui" est sélectionné dans l'ordre, désactiver la sélection de club
            ordreSelect.addEventListener('change', function() {
                if (ordreSelect.value === '1') { // "Oui" sélectionné
                    clubSelect.value = ""; // Réinitialiser le club si l'ordre est sélectionné
                    clubSelect.disabled = true; // Désactiver la sélection de club
                } else {
                    clubSelect.disabled = false; // Si "Non" est sélectionné, réactiver la sélection de club
                }
            });
        }

        window.onload = checkSelection;
    </script>
</head>
<body>

<header>
    <!-- Bouton pour accéder à l'accueil -->
    <a href="../views/accueil.php">
        <button>Accueil</button>
    </a>

    <!-- Bouton pour accéder à la gestion des clubs -->
    <a href="/club">
        <button>Gérer les Clubs</button>
    </a> 

    <!-- Bouton pour accéder à la gestion des repas -->
    <a href="/repas">
        <button>Gérer les Repas</button>
    </a>

    <!-- Bouton pour accéder à la gestion des plats -->
    <a href="/plat">
        <button>Gérer les Plats</button>
    </a>

    <!-- Bouton de déconnexion -->
    <a href='/tenrac/deconnecter'>Se déconnecter</a>
</header>

<h1>Gestion des Tenracs</h1>

<!-- Formulaire pour ajouter ou modifier un tenrac --> 
<form action="/tenrac/inscrire" method="POST" class="boxForm">
    <input type="hidden" name="id" value="<?= isset($tenrac['id']) ? $tenrac['id'] : '' ?>">

    <label>Nom :</label>
    <input type="text" name="nom" value="<?= isset($tenrac['nom']) ? htmlspecialchars($tenrac['nom']) : '' ?>" required><br>

    <label>Adresse :</label>
    <input type="text" name="adresse" value="<?= isset($tenrac['adresse']) ? htmlspecialchars($tenrac['adresse']) : '' ?>" required><br>

    <label>Email :</label>
    <input type="email" name="email" value="<?= isset($tenrac['email']) ? htmlspecialchars($tenrac['email']) : '' ?>" required><br>

    <label>Grade :</label>
    <select name="grade" required>
        <!-- Options de grade -->
        <option value="Affilié" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Affilié' ? 'selected' : '' ?>>Affilié</option>
        <option value="Sympathisant" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Sympathisant' ? 'selected' : '' ?>>Sympathisant</option>
        <option value="Adhérent" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Adhérent' ? 'selected' : '' ?>>Adhérent</option>
        <option value="Chevalier" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Chevalier' ? 'selected' : '' ?>>Chevalier</option>
        <option value="Dame" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Dame' ? 'selected' : '' ?>>Dame</option>
        <option value="Grand Chevalier" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Grand Chevalier' ? 'selected' : '' ?>>Grand Chevalier</option>
        <option value="Commandeur" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Commandeur' ? 'selected' : '' ?>>Commandeur</option>
    </select><br>

    <label>Rang :</label>
    <select name="rang" required>
        <option value="Novice" <?= isset($tenrac['rang']) && $tenrac['rang'] == 'Novice' ? 'selected' : '' ?>>Novice</option>
        <option value="Compagnon" <?= isset($tenrac['rang']) && $tenrac['rang'] == 'Compagnon' ? 'selected' : '' ?>>Compagnon</option>
    </select><br>

    <label>Titre :</label>
    <select name="titre" required>
        <option value="Philanthrope" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Philanthrope' ? 'selected' : '' ?>>Philanthrope</option>
        <option value="Protecteur" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Protecteur' ? 'selected' : '' ?>>Protecteur</option>
        <option value="Honorable" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Honorable' ? 'selected' : '' ?>>Honorable</option>
    </select><br>

    <label>Club :</label>
    <select name="club_id">
        <option value="">Sélectionnez un club</option>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= htmlspecialchars($club['id']) ?>" <?= isset($tenrac['club_id']) && $tenrac['club_id'] == $club['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Ordre :</label>
    <select name="ordre_id">
        <option value="">Non</option>
        <option value="1" <?= isset($tenrac['ordre_id']) && $tenrac['ordre_id'] == 1 ? 'selected' : '' ?>>Oui</option>
    </select><br>

    <label>Dignité :</label>
    <select name="dignite" required>
        <option value="Maitre" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Maitre' ? 'selected' : '' ?>>Maitre</option>
        <option value="Grand Maitre" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Grand Maitre' ? 'selected' : '' ?>>Grand Maitre</option>
        <option value="Grand Chancelier" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Grand Chancelier' ? 'selected' : '' ?>>Grand Chancelier</option>
    </select><br>

    <!-- Suppression du champ de mot de passe ici, remplacé par l'envoi d'un email -->
    
    <label>Téléphone :</label>
    <input type="text" name="tel" value="<?= isset($tenrac['tel']) ? htmlspecialchars($tenrac['tel']) : '' ?>" required><br>

    <button type="submit">S'inscrire</button>
</form>

<!-- Liste des tenracs existants -->
<h2>Tenracs existants</h2>
<ul>
    <?php if (isset($tenracs)) {
        foreach ($tenracs as $tenrac): ?>
            <li>
                <?= htmlspecialchars($tenrac['nom']) ?> - <?= htmlspecialchars($tenrac['email']) ?> - <?= htmlspecialchars($tenrac['grade']) ?>
                <a href="/tenrac/editer/<?= $tenrac['id'] ?>">Modifier</a> |
                <a href="/tenrac/supprimer/<?= $tenrac['id'] ?>">Supprimer</a>
            </li>
        <?php endforeach;
    } ?>
</ul> 
 
</body>  
</html>
  