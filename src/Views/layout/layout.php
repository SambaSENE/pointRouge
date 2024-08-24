<!-- views/layout.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Mon Application'); ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <h1>Mon Application</h1>
        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/about">À propos</a></li>
                <li><a href="/users">Utilisateurs</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; 2024 Mon Application. Tous droits réservés.</p>
    </footer>

    <script src="/js/script.js"></script>
</body>
</html>
