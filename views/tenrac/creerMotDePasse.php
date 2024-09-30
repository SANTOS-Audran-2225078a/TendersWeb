<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <meta name="description" content="Vous êtes ici sur la page qui permet de créer votre mot de passe">
    <link rel="stylesheet" href="/_assets/styles/stylesheet_accueil.css">
    <title>Créer un mot de passe</title>
    <script>                
        /**
         * validerMotDePasse
         *
         * @return void
         */
        function validerMotDePasse(event) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            const errorMessage = document.getElementById('error-message');

            // Réinitialiser le message d'erreur
            errorMessage.textContent = '';

            if (password.length < 8) {
                errorMessage.textContent = 'Le mot de passe doit contenir au moins 8 caractères.';
                event.preventDefault(); // Empêche l'envoi du formulaire
            } else if (password !== confirmPassword) {
                errorMessage.textContent = 'Les mots de passe ne correspondent pas.';
                event.preventDefault(); // Empêche l'envoi du formulaire
            }
        }
    </script>
</head>
<body>
    <h1>Créer votre mot de passe</h1>
    <form action="" method="POST" onsubmit="validerMotDePasse(event)">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>
        
        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" name="confirm_password" required><br>
        
        <!-- Message d'erreur -->
        <p id="error-message" style="color: red;"></p>
        
        <button type="submit">Créer mon mot de passe</button>
    </form>
</body> 
</html>
