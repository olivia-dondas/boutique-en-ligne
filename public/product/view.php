<?php
require_once __DIR__ . '/../../config/autoload.php';
require_once __DIR__.'/../../config/config.php';

$productId = $_GET['id'] ?? null;
if (!$productId) {
    header("Location: /shop");
    exit;
}

$product = (new Product())->getById($productId);
if (!$product) {
    include __DIR__.'/../../templates/error.php';
    exit;
}

include __DIR__.'/../../templates/header.php';
?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <!-- Gallery -->
            <div class="md:w-1/2 p-6">
                <div class="h-96 bg-gray-100 rounded-lg overflow-hidden mb-4">
                    <img src="<?= htmlspecialchars($product['image_url'] ?? '/assets/images/default-product.jpg') ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($product['name']) ?></h1>
                
                <div class="flex items-center mb-4">
                    <span class="text-2xl font-bold text-indigo-600"><?= number_format($product['price'], 2) ?> €</span>
                    <?php if ($product['stock'] > 0): ?>
                        <span class="ml-4 text-sm text-green-600">En stock (<?= $product['stock'] ?>)</span>
                    <?php else: ?>
                        <span class="ml-4 text-sm text-red-600">Rupture de stock</span>
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-600"><?= nl2br(htmlspecialchars($product['description'] ?? 'Aucune description disponible')) ?></p>
                </div>

                <form action="/cart/add" method="POST" class="mb-6">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="mr-4">Quantité :</label>
                        <input type="number" id="quantity" name="quantity" min="1" 
                               max="<?= $product['stock'] ?>" value="1" 
                               class="w-20 px-3 py-2 border rounded">
                    </div>

                    <button type="submit" 
                            class="w-full bg-indigo-600 text-white py-3 px-4 rounded hover:bg-indigo-700 transition-colors <?= $product['stock'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                            <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                        Ajouter au panier
                    </button>
                </form>

                <div class="border-t pt-4">
                    <h3 class="text-lg font-semibold mb-2">Détails</h3>
                    <ul class="text-sm text-gray-600">
                        <li class="py-1"><span class="font-medium">Catégorie :</span> <?= htmlspecialchars($product['category_name'] ?? 'Non catégorisé') ?></li>
                        <?php if (!empty($product['region_name'])): ?>
                        <li class="py-1"><span class="font-medium">Région :</span> <?= htmlspecialchars($product['region_name']) ?></li>
                        <?php endif; ?>
                        <?php if (!empty($product['grape_name'])): ?>
                        <li class="py-1"><span class="font-medium">Cépage :</span> <?= htmlspecialchars($product['grape_name']) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/../../templates/footer.php'; ?>