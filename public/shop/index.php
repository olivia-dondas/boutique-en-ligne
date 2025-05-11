<?php
require_once __DIR__ . '/../../config/autoload.php';
require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../templates/header.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialisation des objets
$product = new Product();
$category = new Category(); 
$region = new Region();
$grape = new Grape();

// Récupération des paramètres
$currentPage = max(1, $_GET['page'] ?? 1);
$perPage = 12;

try {
    // Récupération des filtres
    $filters = [
        'category' => $_GET['category'] ?? null,
        'region' => $_GET['region'] ?? null,
        'grape' => $_GET['grape'] ?? null,
        'price_min' => $_GET['price_min'] ?? 0,
        'price_max' => $_GET['price_max'] ?? 1000,
        'page' => $currentPage,
        'per_page' => $perPage
    ];

    // Récupération des données
    $products = $product->getFilteredProducts($filters);
    $totalProducts = $product->countFilteredProducts($filters);
    $totalPages = ceil($totalProducts / $perPage);
    
    $categories = $category->getAll();
    $regions = $region->getAll();
    $grapes = $grape->getAll();

} catch (Exception $e) {
    error_log("Shop error: " . $e->getMessage());
    include __DIR__.'/../../templates/error.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Boutique de Vins - Bibine</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/tailwind.css">
</head>
<body class="bg-gray-50">
  
    
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Colonne des filtres (côté gauche sur desktop) -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Filtrer les produits</h2>
                    
                    <form method="get" class="space-y-4">
                        <!-- Filtre Catégorie -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="category" class="w-full p-2 border rounded">
                                <option value="">Toutes catégories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" 
                                        <?= ($filters['category'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtre Région -->
                        <?php if (!empty($regions)): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Région</label>
                            <select name="region" class="w-full p-2 border rounded">
                                <option value="">Toutes régions</option>
                                <?php foreach ($regions as $reg): ?>
                                    <option value="<?= $reg['id'] ?>" 
                                        <?= ($filters['region'] == $reg['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($reg['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Filtre Cépage -->
                        <?php if (!empty($grapes)): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cépage</label>
                            <select name="grape" class="w-full p-2 border rounded">
                                <option value="">Tous cépages</option>
                                <?php foreach ($grapes as $grp): ?>
                                    <option value="<?= $grp['id'] ?>" 
                                        <?= ($filters['grape'] == $grp['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grp['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Filtre Prix -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="price_min" placeholder="Min" 
                                       value="<?= $filters['price_min'] ?>" 
                                       class="p-2 border rounded">
                                <input type="number" name="price_max" placeholder="Max" 
                                       value="<?= $filters['price_max'] ?>" 
                                       class="p-2 border rounded">
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                                Appliquer
                            </button>
                            <a href="?" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300 transition text-center">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Contenu principal (côté droit sur desktop) -->
            <div class="w-full lg:w-3/4">
                <!-- En-tête résultats -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <h1 class="text-2xl font-bold text-gray-800">Nos produits</h1>
                        <p class="text-gray-600">
                            <?= $totalProducts ?> produit<?= $totalProducts > 1 ? 's' : '' ?> trouvé<?= $totalProducts > 1 ? 's' : '' ?>
                        </p>
                    </div>
                </div>

                <!-- Liste des produits -->
                <?php if (empty($products)): ?>
                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <p class="text-gray-500 text-lg mb-4">Aucun produit ne correspond à vos critères</p>
                        <a href="?" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Réinitialiser les filtres
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($products as $product): ?>
                            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="relative h-48 bg-gray-100">
                                    <?php if (!empty($product['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>" 
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="text-gray-400">Image non disponible</span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product['featured']): ?>
                                        <span class="absolute top-2 right-2 bg-yellow-400 text-xs font-bold px-2 py-1 rounded">
                                            Coup de cœur
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($product['name']) ?></h2>
                                    <p class="text-gray-600 mb-1"><?= htmlspecialchars($product['category_name'] ?? 'Non catégorisé') ?></p>
                                    <p class="text-lg font-bold text-blue-600 mb-2"><?= number_format($product['price'], 2) ?> €</p>
                                    <p class="text-sm text-gray-500 mb-4">Stock : <?= (int)$product['stock'] ?> disponible<?= $product['stock'] > 1 ? 's' : '' ?></p>
                                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                                        Ajouter au panier
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center mt-8">
                        <nav class="flex items-center gap-1">
                            <?php if ($currentPage > 1): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>" 
                                   class="px-3 py-1 border rounded hover:bg-gray-100">
                                    &laquo;
                                </a>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>" 
                                   class="px-3 py-1 border rounded hover:bg-gray-100">
                                    &lsaquo;
                                </a>
                            <?php endif; ?>

                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                                   class="px-3 py-1 border rounded <?= $i == $currentPage ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>" 
                                   class="px-3 py-1 border rounded hover:bg-gray-100">
                                    &rsaquo;
                                </a>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>" 
                                   class="px-3 py-1 border rounded hover:bg-gray-100">
                                    &raquo;
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__.'/../../templates/footer.php'; ?>
</body>
</html>