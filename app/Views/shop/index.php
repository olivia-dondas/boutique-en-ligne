<?php
// app/Views/shop/index.php
// Variables disponibles : $products, $categories, $regions, $grapes, $filters, $currentPage, $totalPages, $totalProducts, $pageTitle, $baseUrl

$siteName = defined('SITE_NAME') ? SITE_NAME : 'Ma Boutique';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Boutique') ?> - <?= htmlspecialchars($siteName) ?></title>
    <!-- Utilisez le lien vers votre Tailwind compilé ou CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Ou votre CSS local : -->
    <!-- <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl ?? '') ?>css/styles.css"> -->
</head>
<body class="bg-gray-50">
  
    <!-- Barre de Navigation (factoriser dans un layout/header.php si possible) -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="<?= htmlspecialchars($baseUrl ?? '') ?>" class="text-xl font-bold text-red-700"><?= htmlspecialchars($siteName) ?></a>
            <div>
                <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop" class="text-red-700 font-semibold hover:text-red-600 px-3">Boutique</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= htmlspecialchars($baseUrl ?? '') ?>user/profile" class="text-gray-700 hover:text-red-700 px-3">Mon Profil</a>
                    <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/logout" class="text-gray-700 hover:text-red-700 px-3">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/showLoginForm" class="text-gray-700 hover:text-red-700 px-3">Connexion</a>
                    <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/showRegisterForm" class="text-gray-700 hover:text-red-700 px-3">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Colonne des filtres -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Filtrer les produits</h2>
                    
                    <!-- Le formulaire doit pointer vers l'URL actuelle (shop/index ou shop) -->
                    <form method="get" action="<?= htmlspecialchars($baseUrl ?? '') ?>shop" class="space-y-4">
                        <!-- Filtre Catégorie -->
                        <div>
                            <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select id="category_filter" name="category" class="w-full p-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                                <option value="">Toutes catégories</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" 
                                        <?= (isset($filters['category']) && $filters['category'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtre Région -->
                        <?php if (!empty($regions)): ?>
                        <div>
                            <label for="region_filter" class="block text-sm font-medium text-gray-700 mb-1">Région</label>
                            <select id="region_filter" name="region" class="w-full p-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                                <option value="">Toutes régions</option>
                                <?php foreach ($regions as $reg): ?>
                                    <option value="<?= $reg['id'] ?>" 
                                        <?= (isset($filters['region']) && $filters['region'] == $reg['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($reg['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Filtre Cépage -->
                        <?php if (!empty($grapes)): ?>
                        <div>
                            <label for="grape_filter" class="block text-sm font-medium text-gray-700 mb-1">Cépage</label>
                            <select id="grape_filter" name="grape" class="w-full p-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                                <option value="">Tous cépages</option>
                                <?php foreach ($grapes as $grp): ?>
                                    <option value="<?= $grp['id'] ?>" 
                                        <?= (isset($filters['grape']) && $filters['grape'] == $grp['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grp['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <!-- Filtre Prix -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fourchette de Prix</label>
                            <div class="grid grid-cols-2 gap-2 items-center">
                                <input type="number" name="price_min" placeholder="Min €" 
                                       value="<?= htmlspecialchars($filters['price_min'] > 0 ? $filters['price_min'] : '') ?>" 
                                       min="0" step="0.01"
                                       class="p-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                                <input type="number" name="price_max" placeholder="Max €" 
                                       value="<?= htmlspecialchars($filters['price_max'] > 0 ? $filters['price_max'] : '') ?>" 
                                       min="0" step="0.01"
                                       class="p-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-red-700 text-white py-2 px-4 rounded-md hover:bg-red-800 transition">
                                Appliquer Filtres
                            </button>
                            <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop" class="flex-1 bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition text-center">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Contenu principal -->
            <div class="w-full lg:w-3/4">
                <div class="bg-white p-4 rounded-lg shadow-md mb-6 flex flex-col md:flex-row justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">
                        <?= htmlspecialchars($pageTitle ?? 'Nos Produits') ?>
                    </h1>
                    <p class="text-gray-600">
                        <?= $totalProducts ?> produit<?= $totalProducts !== 1 ? 's' : '' ?> trouvé<?= $totalProducts !== 1 ? 's' : '' ?>
                    </p>
                </div>

                <?php if (empty($products)): ?>
                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <p class="text-gray-600 text-lg mb-4">Aucun produit ne correspond à vos critères de recherche.</p>
                        <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop" class="bg-red-700 text-white px-4 py-2 rounded-md hover:bg-red-800 transition">
                            Voir tous les produits
                        </a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-8">
                        <?php foreach ($products as $productData): ?>
                            <?php 
                                $product = $productData;
                                $cardPath = BASE_PATH . '/app/Views/partials/product_card.php';
                                if (file_exists($cardPath)) {
                                    include $cardPath;
                                } else {
                                    echo '<p class="text-red-500 col-span-full">Erreur: Carte produit non trouvée.</p>';
                                    break;
                                }
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center mt-10 pt-6 border-t">
                        <nav class="flex items-center space-x-1">
                            <?php
                            // Garder les filtres actuels dans les liens de pagination
                            $queryParams = $filters; // Utilise les filtres actuels
                            unset($queryParams['page']); // La page sera ajoutée dynamiquement
                            unset($queryParams['per_page']); // Non nécessaire dans l'URL de pagination
                            $baseLink = htmlspecialchars($baseUrl ?? '') . 'shop?' . http_build_query($queryParams);
                            $separator = empty($queryParams) ? '' : '&';
                            ?>

                            <?php if ($currentPage > 1): ?>
                                <a href="<?= $baseLink . $separator ?>page=1" 
                                   class="px-4 py-2 text-gray-600 bg-white rounded-md hover:bg-red-100 border">
                                    &laquo;
                                </a>
                                <a href="<?= $baseLink . $separator ?>page=<?= $currentPage - 1 ?>" 
                                   class="px-4 py-2 text-gray-600 bg-white rounded-md hover:bg-red-100 border">
                                    &lsaquo; Préc.
                                </a>
                            <?php endif; ?>

                            <?php 
                            // Logique pour afficher un nombre limité de pages autour de la page actuelle
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                            if ($startPage > 1) echo '<span class="px-4 py-2 text-gray-600">...</span>';
                            ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <a href="<?= $baseLink . $separator ?>page=<?= $i ?>" 
                                   class="px-4 py-2 border rounded-md <?= $i == $currentPage ? 'bg-red-700 text-white border-red-700' : 'text-gray-600 bg-white hover:bg-red-100' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($endPage < $totalPages) echo '<span class="px-4 py-2 text-gray-600">...</span>'; ?>


                            <?php if ($currentPage < $totalPages): ?>
                                <a href="<?= $baseLink . $separator ?>page=<?= $currentPage + 1 ?>" 
                                   class="px-4 py-2 text-gray-600 bg-white rounded-md hover:bg-red-100 border">
                                    Suiv. &rsaquo;
                                </a>
                                <a href="<?= $baseLink . $separator ?>page=<?= $totalPages ?>" 
                                   class="px-4 py-2 text-gray-600 bg-white rounded-md hover:bg-red-100 border">
                                    &raquo;
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <!-- Footer (factoriser dans un layout/footer.php si possible) -->
   <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($siteName) ?>. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
