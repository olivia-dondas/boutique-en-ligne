<?php
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../templates/header.php';



$product = new Product();
$featuredProducts = $product->getFeatured(4);
?>

<div class="grid grid-cols-4 gap-4">
    <?php foreach ($featuredProducts as $product): ?>
        <?php include __DIR__.'/../templates/product_card.php'; ?>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__.'/../templates/footer.php'; ?>