<?php

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['tenrac'])) {
    $tenrac = $_SESSION['tenrac'];
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: /');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
 
<head> 
    <title>Accueil</title> 
    <script>
        // Fonction pour charger les plats en fonction du club sélectionné
        function chargerPlatsParClub(clubId) {
            fetch('../repas/getPlatsByClub/' + clubId)
                .then(response => response.json())
                .then(data => {
                    let platsContainer = document.getElementById('cartePlats');
                    platsContainer.innerHTML = ''; // Vider les plats affichés précédemment

                    data.forEach(function(plat) {
                        let platDiv = document.createElement('div');
                        platDiv.textContent = plat.nom;
                        platsContainer.appendChild(platDiv);
                    }); 
                });
        }
    </script>
    <link rel="icon" href="../favicon.ico"> 
    <meta name="description" content="Vous êtes ici sur LE site des tenrac. Vous y trouverez des informations sur les différents clubs, 
    les plats et les repas. Vous pourrez aussi en rajouter.">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <link rel="stylesheet" href="../_assets/styles/stylesheet_accueil.css">
    <meta charset="utf-8">
</head> 
 
<body>
    <header>
    <div class="burger-menu" id="burgerMenu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav class="menu" id="menu">
        <!-- Bouton pour accéder à la gestion des clubs -->
        <a href="/club">
            <button>Gérer les Clubs</button>
        </a>

        <!-- Bouton pour accéder à la gestion des plats -->
        <a href="/plat">
            <button>Gérer les Plats</button>
        </a>

        <!-- Bouton pour accéder à la gestion des repas -->
        <a href="/repas">
            <button>Gérer les Repas</button>
        </a>

        <!-- Bouton pour accéder à ses infos personnelles-->
        <a href="/tenrac">
            <button>Les tenrac</button>
        </a>

        <!-- Bouton de déconnexion -->
        <a href='/tenrac/deconnecter'>Se déconnecter</a>
    </nav>
    </header>
<section class="Textimg">
    <h1>Bienvenue, <?= htmlspecialchars($tenrac['nom']) ?> !</h1>
    <img class="image" src="../_assets/images/tenders_raclette.webp" alt="Image de tenders à la raclette">
</section>
<section class="Liste">
    <div class="box">
        <p>Bienvenue sur LE site Tenrac. Ici vous pourrez retrouver toutes les informations que vous voudrez sur notre communauté !
        Que ce soit nos clubs, nos repas, nos plats ou encore les différents tenracs qui composent notre communauté</p>
    </div>

    <div class="box">
        <p> Ici vous pouvez observer un exemple de plat que vous pourrez trouver sur notre site.</p>
        <img class="image" src="../_assets/images/tacos_tender_mangue.webp" alt="Image de tacos tenders mangue">
    </div>
<section>

<h2>Repas existants</h2>
<?php if (!empty($repas)): ?>
    <?php foreach ($repas as $r): ?>
        <div class="repas-container">
            <h3><?= htmlspecialchars($r['nom'] ?? 'Repas sans nom') ?></h3> <!-- Affiche uniquement le nom du repas -->
            <div class="repas-details">
                <p><strong>Date :</strong> <?= htmlspecialchars($r['date'] ?? '') ?></p>
                <p><strong>Participants :</strong> <?= htmlspecialchars($r['participants'] ?? '') ?></p>
                <p><strong>Chef de rencontre :</strong> <?= htmlspecialchars($r['chef_de_rencontre'] ?? '') ?></p>
                <p><strong>Adresse (Club) :</strong> <?= htmlspecialchars($r['club_nom'] ?? '') ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun repas disponible.</p>
<?php endif; ?>
<script>
    document.getElementById('burgerMenu').addEventListener('click', function () {
        var menu = document.getElementById('menu');
        menu.classList.toggle('active');
    });
</script>
</body>
</html>