<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>

<body>
    <h1>Inscription</h1>
    <form action="/register" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <button type="submit">S'inscrire</button>
    </form>
</body>

</html>