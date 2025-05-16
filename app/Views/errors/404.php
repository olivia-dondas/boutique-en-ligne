<?php
// app/Views/errors/404.php
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Ma Boutique';
// $pageTitle est passé par le contrôleur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Page Introuvable') ?> - <?= htmlspecialchars($siteName) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="<?= htmlspecialchars($baseUrl ?? '') ?>" class="text-xl font-bold text-red-700"><?= htmlspecialchars($siteName) ?></a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-4 py-16 text-center">
        <h1 class="text-6xl font-bold text-red-700 mb-4">404</h1>
        <h2 class="text-3xl font-semibold text-gray-700 mb-6"><?= htmlspecialchars($pageTitle ?? 'Page Introuvable') ?></h2>
        <p class="text-gray-600 mb-8">Désolé, la page que vous recherchez n'a pas pu être trouvée.</p>
        <a href="<?= htmlspecialchars($baseUrl ?? '') ?>" class="bg-red-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition">
            Retour à l'accueil
        </a>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($siteName) ?>. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
