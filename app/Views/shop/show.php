<?php
// app/Views/shop/show.php
// Variables attendues du contrôleur :
// - $product (array) : Détails du produit (name, description, price, stock, category_name, region_name, grape_name, etc.)
// - $productImages (array) : Tableau des images associées au produit (chaque élément avec 'image_url')
// - $pageTitle (string)
// - $baseUrl (string)

require_once BASE_PATH . '/app/Views/layouts/header.php';
?>

<main class="container mx-auto px-4 py-8">
    <?php if (isset($product) && is_array($product) && !empty($product['id'])): ?>
        <div class="bg-white rounded-lg shadow-xl p-4 sm:p-6 md:p-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                <!-- Section Images -->
                <div class="lg:col-span-1">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg mb-4 shadow">
                        <?php
                        // Déterminer l'image principale à afficher
                        $mainImageUrl = htmlspecialchars($baseUrl ?? '') . 'assets/images/default-wine-large.jpg'; // Image par défaut

                        if (!empty($productImages) && isset($productImages[0]['image_url'])) {
                            $img = ltrim($productImages[0]['image_url'], '/');
                            if (strpos($img, 'assets/') !== 0) {
                                $img = 'assets/products/' . $img;
                            }
                            $mainImageUrl = htmlspecialchars($baseUrl ?? '') . $img;
                        } elseif (isset($product['image_url']) && !empty($product['image_url'])) {
                            $img = ltrim($product['image_url'], '/');
                            if (strpos($img, 'assets/') !== 0) {
                                $img = 'assets/products/' . $img;
                            }
                            $mainImageUrl = htmlspecialchars($baseUrl ?? '') . $img;
                        }
                        ?>
                        <img id="mainProductImage" src="<?= $mainImageUrl ?>" 
                             alt="Image principale de <?= htmlspecialchars($product['name']) ?>" 
                             class="w-full h-full object-contain object-center border border-gray-200 bg-gray-50 p-2">
                    </div>

                    <?php if (!empty($productImages) && count($productImages) > 1): ?>
                        <div class="hidden sm:grid grid-cols-4 gap-2">
                            <?php foreach ($productImages as $img): ?>
                                <?php
                                    $thumb = ltrim($img['image_url'], '/');
                                    if (strpos($thumb, 'assets/') !== 0) {
                                        $thumb = 'assets/products/' . $thumb;
                                    }
                                    $thumbUrl = htmlspecialchars($baseUrl ?? '') . $thumb;
                                ?>
                                <div class="aspect-w-1 aspect-h-1 rounded-md overflow-hidden cursor-pointer border-2 border-transparent hover:border-red-500 transition-all"
                                     onclick="document.getElementById('mainProductImage').src='<?= $thumbUrl ?>'">
                                    <img src="<?= $thumbUrl ?>" 
                                         alt="Miniature de <?= htmlspecialchars($product['name']) ?>"
                                         class="w-full h-full object-cover object-center">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Section Détails -->
                <div class="lg:col-span-1 mt-6 lg:mt-0">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                        <?= htmlspecialchars($product['name']) ?>
                    </h1>

                    <?php if (!empty($product['category_name'])): ?>
                        <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop?category=<?= $product['category_id'] ?? '' ?>" 
                           class="inline-block bg-red-100 text-red-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full hover:bg-red-200 transition mb-4">
                            <?= htmlspecialchars($product['category_name']) ?>
                        </a>
                    <?php endif; ?>
                    
                    <p class="text-3xl font-bold text-red-700 mb-6">
                        <?= number_format($product['price'], 2, ',', ' ') ?> €
                    </p>
                    
                    <div class="prose prose-sm sm:prose-base max-w-none text-gray-600 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1 border-b pb-1">Description</h3>
                        <p><?= nl2br(htmlspecialchars($product['description'] ?? 'Aucune description pour ce produit.')) ?></p>
                    </div>

                    <!-- Stock et Bouton Ajouter au Panier -->
                    <div class="mb-6">
                        <?php if (isset($product['stock']) && $product['stock'] > 0): ?>
                            <p class="text-sm text-green-600 font-medium mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 -mt-px" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                En stock (<?= htmlspecialchars($product['stock']) ?> unité<?= $product['stock'] > 1 ? 's' : '' ?>)
                            </p>
                            <form action="<?= htmlspecialchars($baseUrl ?? '') ?>cart/add" method="POST" class="mt-1">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <div class="flex items-center space-x-3">
                                    <label for="quantity" class="text-sm font-medium text-gray-700">Quantité:</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" 
                                           class="w-20 py-2 px-3 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500 text-center">
                                    <button type="submit" class="flex-1 bg-red-700 text-white py-2.5 px-5 rounded-lg font-semibold hover:bg-red-800 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 shadow-sm hover:shadow-md">
                                        Ajouter au Panier
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 font-medium mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 -mt-px" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 102 0V5zm-1 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                Actuellement indisponible
                            </p>
                            <button class="w-full bg-gray-300 text-gray-500 py-2.5 px-5 rounded-lg font-semibold cursor-not-allowed" disabled>
                                Indisponible
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="text-base font-medium text-gray-900 mb-3">Détails supplémentaires :</h4>
                        <dl class="space-y-2">
                            <?php if (!empty($product['color'])): ?>
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Couleur :</dt>
                                    <dd class="text-gray-900 font-medium"><?= htmlspecialchars(ucfirst($product['color'])) ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($product['region_name'])): ?>
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Région :</dt>
                                    <dd class="text-gray-900 font-medium"><?= htmlspecialchars($product['region_name']) ?> (<?= htmlspecialchars($product['region_country'] ?? '') ?>)</dd>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($product['grape_name'])): ?>
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Cépage principal :</dt>
                                    <dd class="text-gray-900 font-medium"><?= htmlspecialchars($product['grape_name']) ?></dd>
                                </div>
                                <?php if(!empty($product['grape_description'])): ?>
                                    <dd class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($product['grape_description']) ?></dd>
                                <?php endif; ?>
                            <?php endif; ?>
                             <?php /* if (!empty($product['brand_name'])): // Si vous avez une table brand
                                <div class="flex justify-between text-sm">
                                    <dt class="text-gray-500">Producteur :</dt>
                                    <dd class="text-gray-900 font-medium"><?= htmlspecialchars($product['brand_name']) ?></dd>
                                </div>
                            <?php endif; */ ?>
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-500">Référence :</dt>
                                <dd class="text-gray-900 font-medium">PRD-<?= htmlspecialchars(str_pad($product['id'] ?? 0, 5, "0", STR_PAD_LEFT)) ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="mt-10 sm:mt-12 text-center">
                <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop" 
                   class="text-red-600 hover:text-red-800 font-medium inline-flex items-center group text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 transform transition-transform duration-200 group-hover:-translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Retour à la boutique
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-md shadow" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM9 11v2h2v-2H9zm0-6v4h2V5H9z"/></svg></div>
                <div>
                    <p class="font-bold">Produit introuvable</p>
                    <p class="text-sm">Le produit que vous cherchez n'existe pas ou n'est plus disponible.</p>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <a href="<?= htmlspecialchars($baseUrl ?? '') ?>shop" class="text-red-600 hover:text-red-800 font-medium text-sm">
                Retour à la boutique
            </a>
        </div>
    <?php endif; ?>
</main>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
