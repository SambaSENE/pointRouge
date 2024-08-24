<!-- views/user/update.php -->
<?php
$title = 'Modifier l\'utilisateur';
ob_start();
?>

<h1>Modifier l'utilisateur</h1>

<form action="/user/<?php echo $user->getId(); ?>/update" method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->getUsername()); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password">

    <button type="submit">Mettre à jour</button>
</form>

<a href="/users">Retour à la liste des utilisateurs</a>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
