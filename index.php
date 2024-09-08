<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Autoload les classes (Modèle, Vue, Contrôleur)
require_once 'routeur.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialiser le routeur
$routeur = new Routeur();
$routeur->gererRequete();