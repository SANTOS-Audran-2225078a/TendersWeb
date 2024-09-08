<h1>Liste des Tenracs</h1>
<table>
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Adresse</th>
        <th>Grade</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($tenracs as $tenrac) : ?>
    <tr>
        <td><?= htmlspecialchars($tenrac['nom']) ?></td>
        <td><?= htmlspecialchars($tenrac['email']) ?></td>
        <td><?= htmlspecialchars($tenrac['tel']) ?></td>
        <td><?= htmlspecialchars($tenrac['adresse']) ?></td>
        <td><?= htmlspecialchars($tenrac['grade']) ?></td>
        <td>
            <a href="/tenrac/modifier/<?= $tenrac['id'] ?>">Modifier</a>
            <a href="/tenrac/supprimer/<?= $tenrac['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce tenrac ?');">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="/tenrac/ajouter">Ajouter un Tenrac</a>
