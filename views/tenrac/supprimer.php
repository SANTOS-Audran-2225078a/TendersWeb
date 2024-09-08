<h1>Confirmer la suppression</h1>

<p>Êtes-vous sûr de vouloir supprimer le Tenrac suivant : <?= htmlspecialchars($tenrac['nom']) ?> ?</p>

<form method="POST" action="/tenrac/supprimer/<?= $tenrac['id'] ?>">
    <button type="submit">Oui, supprimer</button>
</form>

<a href="/tenrac/liste">Annuler</a>
