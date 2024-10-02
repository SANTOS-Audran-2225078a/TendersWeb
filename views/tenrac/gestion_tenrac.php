<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des Tenracs</title>
    <meta name="description" content="Vous êtes ici sur la page qui permet d'inscrire d'autres tenracs, n'hésitez pas à inscrire vos amis afin qu'il rejoigne la meilleure communauté ">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <script>
        // Désactive la sélection de club si "Oui" est sélectionné pour l'ordre et inversement
        /**
         * checkSelection
         *
         * @return void
         */
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
    <div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="menu" id="menu">
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
    </nav>
</header>

<h1>Gestion des Tenracs</h1>

<!-- Formulaire pour ajouter un tenrac -->
<form action="/tenrac/inscrire" method="POST" class="boxForm">
    <label for="nomT">Nom :</label>
    <input id="nomT" type="text" name="nom" required><br>

    <label for="adresseT">Adresse :</label>
    <input id="adresseT" type="text" name="adresse" required><br>

    <label for="emailT">Email :</label>
    <input id="emailT" type="email" name="email" required><br>

    <label for="gradeT">Grade :</label>
    <select id="gradeT" name="grade" required>
        <!-- Options de grade -->
        <option value="Affilié">Affilié</option>
        <option value="Sympathisant">Sympathisant</option>
        <option value="Adhérent">Adhérent</option>
        <option value="Chevalier">Chevalier</option>
        <option value="Dame">Dame</option>
        <option value="Grand Chevalier">Grand Chevalier</option>
        <option value="Commandeur">Commandeur</option>
    </select><br>

    <label for="rangT">Rang :</label>
    <select id="rangT" name="rang" required>
        <option value="Novice">Novice</option>
        <option value="Compagnon">Compagnon</option>
    </select><br>

    <label for="titreT">Titre :</label>
    <select id="titreT" name="titre" required>
        <option value="Philanthrope">Philanthrope</option>
        <option value="Protecteur">Protecteur</option>
        <option value="Honorable">Honorable</option>
    </select><br>

    <label for="clubT">Club :</label>
    <select id="clubT" name="club_id">
        <option value="">Sélectionnez un club</option>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= htmlspecialchars($club['id']) ?>">
                <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="ordreT">Ordre :</label>
    <select id="ordreT" name="ordre_id">
        <option value="">Non</option>
        <option value="1">Oui</option>
    </select><br>

    <label for="digniteT">Dignité :</label>
    <select id="digniteT" name="dignite" required>
        <option value="Maitre">Maitre</option>
        <option value="Grand Maitre">Grand Maitre</option>
        <option value="Grand Chancelier">Grand Chancelier</option>
    </select><br>

    <label for="telT">Téléphone :</label>
    <input id="telT" type="text" name="tel" required><br>

    <button type="submit">S'inscrire</button>
</form>

<!-- Formulaire pour modifier un tenrac -->
<?php if (isset($tenrac)): ?>
    <form action="/tenrac/modifierTenrac" method="POST" class="boxForm">
        <input type="hidden" name="id" value="<?= htmlspecialchars($tenrac['id']) ?>">

        <label for="nomT">Nom :</label>
        <input id="nomT" type="text" name="nom" value="<?= htmlspecialchars($tenrac['nom']) ?>" required><br>

        <label for="adresseT">Adresse :</label>
        <input id="adresseT" type="text" name="adresse" value="<?= htmlspecialchars($tenrac['adresse']) ?>" required><br>

        <label for="emailT">Email :</label>
        <input id="emailT" type="email" name="email" value="<?= htmlspecialchars($tenrac['email']) ?>" required><br>

        <label for="gradeT">Grade :</label>
        <select id="gradeT" name="grade" required>
            <!-- Options de grade -->
            <option value="Affilié" <?= $tenrac['grade'] == 'Affilié' ? 'selected' : '' ?>>Affilié</option>
            <option value="Sympathisant" <?= $tenrac['grade'] == 'Sympathisant' ? 'selected' : '' ?>>Sympathisant</option>
            <option value="Adhérent" <?= $tenrac['grade'] == 'Adhérent' ? 'selected' : '' ?>>Adhérent</option>
            <option value="Chevalier" <?= $tenrac['grade'] == 'Chevalier' ? 'selected' : '' ?>>Chevalier</option>
            <option value="Dame" <?= $tenrac['grade'] == 'Dame' ? 'selected' : '' ?>>Dame</option>
            <option value="Grand Chevalier" <?= $tenrac['grade'] == 'Grand Chevalier' ? 'selected' : '' ?>>Grand Chevalier</option>
            <option value="Commandeur" <?= $tenrac['grade'] == 'Commandeur' ? 'selected' : '' ?>>Commandeur</option>
        </select><br>

        <label for="rangT">Rang :</label>
        <select id="rangT" name="rang" required>
            <option value="Novice" <?= $tenrac['rang'] == 'Novice' ? 'selected' : '' ?>>Novice</option>
            <option value="Compagnon" <?= $tenrac['rang'] == 'Compagnon' ? 'selected' : '' ?>>Compagnon</option>
        </select><br>

        <label for="titreT">Titre :</label>
        <select id="titreT" name="titre" required>
            <option value="Philanthrope" <?= $tenrac['titre'] == 'Philanthrope' ? 'selected' : '' ?>>Philanthrope</option>
            <option value="Protecteur" <?= $tenrac['titre'] == 'Protecteur' ? 'selected' : '' ?>>Protecteur</option>
            <option value="Honorable" <?= $tenrac['titre'] == 'Honorable' ? 'selected' : '' ?>>Honorable</option>
        </select><br>

        <label for="clubT">Club :</label>
        <select id="clubT" name="club_id">
            <option value="">Sélectionnez un club</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= htmlspecialchars($club['id']) ?>" <?= $tenrac['club_id'] == $club['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($club['nom']) ?> - <?= htmlspecialchars($club['adresse']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="ordreT">Ordre :</label>
        <select id="ordreT" name="ordre_id">
            <option value="">Non</option>
            <option value="1" <?= $tenrac['ordre_id'] == 1 ? 'selected' : '' ?>>Oui</option>
        </select><br>

        <label for="digniteT">Dignité :</label>
        <select id="digniteT" name="dignite" required>
            <option value="Maitre" <?= $tenrac['dignite'] == 'Maitre' ? 'selected' : '' ?>>Maitre</option>
            <option value="Grand Maitre" <?= $tenrac['dignite'] == 'Grand Maitre' ? 'selected' : '' ?>>Grand Maitre</option>
            <option value="Grand Chancelier" <?= $tenrac['dignite'] == 'Grand Chancelier' ? 'selected' : '' ?>>Grand Chancelier</option>
        </select><br>

        <label for="telT">Téléphone :</label>
        <input id="telT" type="text" name="tel" value="<?= htmlspecialchars($tenrac['tel']) ?>" required><br>

        <button type="submit">Modifier</button>
    </form>
<?php endif; ?>

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

<script>
    document.getElementById('burgerMenu').addEventListener('click', function () {
        var menu = document.getElementById('menu');
        menu.classList.toggle('active');
    });
</script>

</body>
</html>
