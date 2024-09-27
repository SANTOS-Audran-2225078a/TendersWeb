<?php
// Connexion à la base de données
try {
    $db = new PDO('mysql:host=mysql-iut.alwaysdata.net;dbname=iut_tendersweb', 'iut_tendrac', 'tendrac123.');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Hachage du nouveau mot de passe 'zouzou'
$nouveauHash = password_hash('zouzou', PASSWORD_DEFAULT);

// Mise à jour du mot de passe pour l'utilisateur avec l'ID 8 (ou un autre ID correspondant)
$idUtilisateur = 8;
$query = $db->prepare('UPDATE tenrac SET password = :password WHERE id = :id');
$query->bindParam(':password', $nouveauHash);
$query->bindParam(':id', $idUtilisateur);
$query->execute();

echo 'Le mot de passe a été mis à jour avec succès.';
?>
