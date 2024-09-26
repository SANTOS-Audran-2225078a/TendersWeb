<!DOCTYPE html>
<html>
    <header>
<img url="./favicon.ico">
</header>
<head>
    <title>Gestion des Tenracs</title>
    <meta name="description" content="Vous êtes ici sur LE site des tenrac. Vous y trouverez des informations sur les différents clubs, 
    les plats et les repas. VOus pourrez aussi en rajouter.">
    <link rel="stylesheet" href="../_assets/styles/stylesheet_login.css">
</head>
<body>
    <h1>Gestion des Tenracs</h1>

    <!-- Formulaire pour ajouter ou modifier un tenrac -->
    <form action="/tenrac/sauvegarder" method="POST">
        <input type="hidden" name="id" value="<?= isset($tenrac['id']) ? $tenrac['id'] : '' ?>">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= isset($tenrac['nom']) ? htmlspecialchars($tenrac['nom']) : '' ?>" required><br>
        <label>Adresse :</label>
        <input type="text" name="adresse" value="<?= isset($tenrac['adresse']) ? htmlspecialchars($tenrac['adresse']) : '' ?>" required><br>
        <label>Email :</label>
        <input type="email" name="email" value="<?= isset($tenrac['email']) ? htmlspecialchars($tenrac['email']) : '' ?>" required><br>
        <label style="vertical-align: top;"> Grade :</label>
        <select name="grade" required>
            <option value="Affilié" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Affilié' ? 'selected' : '' ?>>Affilié</option>
            <option value="Sympathisant" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Sympathisant' ? 'selected' : '' ?>>Sympathisant</option>
            <option value="Adhérent" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Adhérent' ? 'selected' : '' ?>>Adhérent</option>
            <option value="Chevalier" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Chevalier' ? 'selected' : '' ?>>Chevalier</option>
            <option value="Dame" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Dame' ? 'selected' : '' ?>>Dame</option>
            <option value="Grand Chevalier" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Grand Chevalier' ? 'selected' : '' ?>>Grand Chevalier</option>
            <option value="Haute Dame" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Haute Dame' ? 'selected' : '' ?>>Haute Dame</option>
            <option value="Commandeur" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Commandeur' ? 'selected' : '' ?>>Commandeur</option>
            <option value="Grand'Croix" <?= isset($tenrac['grade']) && $tenrac['grade'] == 'Grand\'Croix' ? 'selected' : '' ?>>Grand'Croix</option>
        </select><br>
        <label style="vertical-align: top;">Rang :</label>
        <select name="rang" required>
            <option value="Novice" <?= isset($tenrac['rang']) && $tenrac['rang'] == 'Novice' ? 'selected' : '' ?>>Novice</option>
            <option value="Compagnon" <?= isset($tenrac['rang']) && $tenrac['rang'] == 'Compagnon' ? 'selected' : '' ?>>Compagnon</option>
        </select><br>
        <label style="vertical-align: top;">Titre :</label>
        <select name="titre" required>
            <option value="Philanthrope" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Philanthrope' ? 'selected' : '' ?>>Philanthrope</option>
            <option value="Protecteur" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Protecteur' ? 'selected' : '' ?>>Protecteur</option>
            <option value="Honorable" <?= isset($tenrac['titre']) && $tenrac['titre'] == 'Honorable' ? 'selected' : '' ?>>Honorable</option>
        </select><br>
        <label>Club ID :</label>
        <input type="number" name="club_id" value="<?= isset($tenrac['club_id']) ? htmlspecialchars($tenrac['club_id']) : '' ?>" required><br>
        <label>Ordre ID :</label>
        <input type="number" name="ordre_id" value="<?= isset($tenrac['ordre_id']) ? htmlspecialchars($tenrac['ordre_id']) : '' ?>" required><br>
        <label style="vertical-align: top;">Dignité :</label>
        <select name="dignite" required>
            <option value="Maitre" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Maitre' ? 'selected' : '' ?>>Maitre</option>
            <option value="Grand Maitre" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Grand Maitre' ? 'selected' : '' ?>>Grand Maitre</option>
            <option value="Grand Chancelier" <?= isset($tenrac['dignite']) && $tenrac['dignite'] == 'Grand Chancelier' ? 'selected' : '' ?>>Grand Chancelier</option>
        </select><br>
        <label>Mot de passe :</label>
        <input type="password" name="password" value="<?= isset($tenrac['password']) ? htmlspecialchars($tenrac['password']) : '' ?>" required><br>
        <label>Téléphone :</label>
        <input type="text" name="tel" value="<?= isset($tenrac['tel']) ? htmlspecialchars($tenrac['tel']) : '' ?>" required><br>
        <button type="submit">Sauvegarder</button>
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
 
    <!-- Bouton Retour à l'accueil -->
    <a href="/tenrac/accueil">
        <button>Retour à l'Accueil</button>
    </a>
</body> 
</html>