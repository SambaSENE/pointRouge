<!-- views/user/create.php -->
<?php
$title = 'Créer un nouvel utilisateur';
ob_start();
?>

<h1>Créer un nouvel utilisateur</h1>

<form action="/user/create" method="post">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Créer</button>
</form>

<a href="/users">Retour à la liste des utilisateurs</a>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
