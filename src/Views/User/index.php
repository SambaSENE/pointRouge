<!-- views/User/index.php -->
<h1>Liste des utilisateurs</h1>

<?php if (!empty($users)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user->getId_user()); ?></td>
                    <td><?php echo htmlspecialchars($user->getUsername()); ?></td>
                    <td><?php echo htmlspecialchars($user->getEmail_user()); ?></td>
                    <td>
                        <a href="/user/<?php echo $user->getId_user(); ?>">Voir</a> |
                        <a href="/user/<?php echo $user->getId_user(); ?>/update">Modifier</a> |
                        <a href="/user/<?php echo $user->getId_user(); ?>/delete">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun utilisateur trouvé.</p>
<?php endif; ?>
