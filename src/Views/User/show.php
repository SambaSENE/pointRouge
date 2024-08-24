<!-- views/user/show.php -->
<?php
$title = 'Détails de l\'utilisateur';
ob_start();  // Commence la mise en mémoire tampon de sortie
?>

<h1>Détails de l'utilisateur</h1>
<p><strong>ID:</strong> <?php echo htmlspecialchars($user->getId_user()); ?></p>
<p><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($user->getUsername()); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user->getEmail_user()); ?></p>
<p><strong>Créé le:</strong> <?php echo htmlspecialchars($user->getCreate_At()->format('Y-m-d H:i:s')); ?></p>

<a href="/users">Retour à la liste des utilisateurs</a>

<?php
$content = ob_get_clean();  // Arrête la mise en mémoire tampon et obtient son contenu
include __DIR__ . '/../layout/layout.php';  // Inclut le layout
