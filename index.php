<?php
// Autoload les classes (Modèle, Vue, Contrôleur)
require_once 'routeur.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Initialiser le routeur
$routeur = new Routeur();
$routeur->gererRequete();
