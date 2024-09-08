<h1>Modifier le Tenrac</h1>

<form method="POST" action="/tenrac/modifier/<?= $tenrac['id'] ?>">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($tenrac['nom']) ?>" required><br>

    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($tenrac['email']) ?>" required><br>

    <label>Téléphone :</label>
    <input type="text" name="tel" value="<?= htmlspecialchars($tenrac['tel']) ?>" required><br>

    <label>Adresse :</label>
    <input type="text" name="adresse" value="<?= htmlspecialchars($tenrac['adresse']) ?>" required><br>

    <label>Grade :</label>
    <input type="text" name="grade" value="<?= htmlspecialchars($tenrac['grade']) ?>" required><br>

    <label>Ordre :</label>
    <input type="text" name="ordre_id" value="<?= htmlspecialchars($tenrac['ordre_id']) ?>" required><br>

    <label>Club :</label>
    <input type="text" name="club_id" value="<?= htmlspecialchars($tenrac['club_id']) ?>" required><br>

    <button type="submit">Modifier</button>
</form>

<a href="/tenrac/liste">Retour à la liste</a>
