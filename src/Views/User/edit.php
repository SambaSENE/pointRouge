<!-- views/user/edit.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'utilisateur</title>
</head>
<body>
    <h1>Modifier l'utilisateur</h1>
    <form action="/user/<?php echo $user->getId_user(); ?>/update" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail_user()); ?>" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user->getPassword_user()); ?>" required>

        <button type="submit">Mettre à jour</button>
    </form>
    <a href="/users">Retour à la liste des utilisateurs</a>
</body>
</html>
