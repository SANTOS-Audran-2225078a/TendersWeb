<?php
// Autoload les classes (Modèle, Vue, Contrôleur)
require_once 'routeur.php';

// Initialiser le routeur
$routeur = new Routeur();
$routeur->gererRequete();
