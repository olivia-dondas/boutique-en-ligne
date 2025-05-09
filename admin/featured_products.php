<?php
require_once __DIR__.'/../../config/auth.php'; // Sécurise l'accès admin
require_once __DIR__.'/../../classes/Product.php';

$product = new Product();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (int)$_POST['product_id'];
    $action = $_POST['action'];
    
    if ($action === 'add') {
        $product->setFeaturedStatus($productId, 1);
    } elseif ($action === 'remove') {
        $product->setFeaturedStatus($productId, 0);
    }
}

// Liste des produits
$allProducts = $product->getAll();
$featuredProducts = $product->getFeatured(100); // On en récupère beaucoup
?>

<!-- Formulaire de gestion -->
<div class="grid grid-cols-2 gap-8">
    <div>
        <h3>Produits phares actuels</h3>
        <?php foreach ($featuredProducts as $prod): ?>
            <div class="flex justify-between items-center p-2 border-b">
                <?= htmlspecialchars($prod['name']) ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" class="text-red-600">Retirer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div>
        <h3>Tous les produits</h3>
        <?php foreach ($allProducts as $prod): ?>
            <div class="flex justify-between items-center p-2 border-b">
                <?= htmlspecialchars($prod['name']) ?>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="text-green-600">Ajouter</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>