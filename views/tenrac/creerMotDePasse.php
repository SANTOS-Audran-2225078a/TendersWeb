<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un mot de passe</title>
</head>
<body>
    <h1>Créer votre mot de passe</h1>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>
        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" name="confirm_password" required><br>
        <button type="submit">Créer mon mot de passe</button>
    </form>
</body>
</html>