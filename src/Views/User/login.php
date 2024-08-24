<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>
    <h1>Connexion</h1>
    <form action="/login" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <button type="submit">Se connecter</button>
    </form>
</body>

</html>