<?php
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../templates/header.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$product = new Product();
$featuredProducts = $product->getFeatured(4);
$categories = $product->getAllCategories();
?>

<!-- Hero Section Vinicole -->
<section class="hero bg-gradient-to-r from-red-900 to-amber-900 text-white py-16 mb-12 text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-4">Votre Cave à Vins d'Exception</h1>
        <p class="text-xl mb-6">Découvrez des crus rares et des grands classiques</p>
        <a href="/products" class="bg-white text-red-900 px-6 py-3 rounded-lg font-medium hover:bg-amber-100 transition">
            Explorer notre sélection
        </a>
    </div>
</section>


<div class="grid grid-cols-4 gap-4">
    <?php foreach ($featuredProducts as $product): ?>
        <?php include __DIR__.'/../templates/product_card.php'; ?>
    <?php endforeach; ?>
</div>

<?php include '../templates/footer.php'; ?>

