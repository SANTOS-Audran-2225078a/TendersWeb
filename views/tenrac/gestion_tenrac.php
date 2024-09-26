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
        <label>Grade :</label>
        <input type="text" name="grade" value="<?= isset($tenrac['grade']) ? htmlspecialchars($tenrac['grade']) : '' ?>" required><br>
        <label>Club ID :</label>
        <input type="number" name="club_id" value="<?= isset($tenrac['club_id']) ? htmlspecialchars($tenrac['club_id']) : '' ?>" required><br>
        <label>Ordre ID :</label>
        <input type="number" name="ordre_id" value="<?= isset($tenrac['ordre_id']) ? htmlspecialchars($tenrac['ordre_id']) : '' ?>" required><br>
        <label>Dignité :</label>
        <input type="text" name="dignite" value="<?= isset($tenrac['dignite']) ? htmlspecialchars($tenrac['dignite']) : '' ?>" required><br>
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