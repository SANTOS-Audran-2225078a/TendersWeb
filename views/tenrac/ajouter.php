<h1>Ajouter un Tenrac</h1>
<form method="POST" action="/tenrac/ajouter">
    <label>Nom :</label>
    <input type="text" name="nom" required><br>

    <label>Email :</label>
    <input type="email" name="email" required><br>

    <label>Téléphone :</label>
    <input type="text" name="tel" required><br>

    <label>Adresse :</label>
    <input type="text" name="adresse" required><br>

    <label>Grade :</label>
    <input type="text" name="grade" required><br>

    <label>Ordre :</label>
    <input type="text" name="ordre_id" required><br>

    <label>Club :</label>
    <input type="text" name="club_id" required><br>

    <button type="submit">Ajouter</button>
</form>
<a href="/tenrac/liste">Retour à la liste</a>
