<?php
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../templates/header.php';

// Debug temporaire - à supprimer après vérification
$product = new Product();
$featuredProducts = $product->getFeatured(4);

// Supprimer ces lignes après debug
echo '<pre>Requête SQL: ' . $product->getLastQuery() . '</pre>'; // Ajoutez getLastQuery() dans Product
echo '<pre>Produits récupérés: ';
print_r($featuredProducts);
echo '</pre>';
// Fin du debug à supprimer

// Hero Section Vinicole
?>
<section class="hero bg-gradient-to-r from-red-900 to-amber-900 text-white py-16 mb-12 text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-4">Votre Cave à Vins d'Exception</h1>
        <p class="text-xl mb-6">Découvrez des crus rares et des grands classiques</p>
        <a href="../public/shop/index.php" class="bg-white text-red-900 px-6 py-3 rounded-lg font-medium hover:bg-amber-100 transition">
            Explorer notre sélection
        </a>
    </div>
</section>

<?php if (empty($featuredProducts)): ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-amber-100 border-l-4 border-amber-500 text-amber-700 p-4">
            <p>Aucun produit en vedette pour le moment. Revenez bientôt !</p>
        </div>
    </div>
<?php else: ?>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Nos Sélections Exceptionnelles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($featuredProducts as $product): ?>
                <?php include __DIR__.'/../templates/partials/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; 

include __DIR__.'/../templates/footer.php';