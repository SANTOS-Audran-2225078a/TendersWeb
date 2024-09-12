<?php
$start = microtime(true);

try {
    $pdo = new PDO('mysql:host=mysql-iut.alwaysdata.net;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $end = microtime(true);
    echo "Connexion réussie. Temps d'exécution : " . ($end - $start) . " secondes";
} catch (PDOException $e) {
    $end = microtime(true);
    echo "Erreur : " . $e->getMessage() . " (Temps d'exécution : " . ($end - $start) . " secondes)";
}
?>