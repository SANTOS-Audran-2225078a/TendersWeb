<?php

// Vérifier si l'tenrac est connecté
if (isset($_SESSION['tenrac'])) {
    $tenrac = $_SESSION['tenrac'];
    $nomtenrac = $tenrac['nom']; // Assurez-vous que la clé 'nom' existe dans votre tableau tenrac
    echo "<h1>Bienvenue, $nomtenrac !</h1>";
} else {
    // Si l'tenrac n'est pas connecté, rediriger vers la page de connexion
    header('Location: /login');
    exit();
}
?>