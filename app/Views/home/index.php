<?php
// app/Views/home/index.php
require_once BASE_PATH . '/app/Views/layouts/header.php';

$siteName = defined('SITE_NAME') ? SITE_NAME : 'Ma Boutique';
$pageTitle = $siteName . " - Accueil"; // Titre spécifique pour la page d'accueil

?>

    <!-- Hero Section Vinicole  -->
    <section class="hero bg-gradient-to-r from-red-900 to-amber-900 text-white py-16 mb-12 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">Votre Cave à Vins d'Exception</h1>
            <p class="text-xl mb-6">Découvrez des crus rares et des grands classiques</p>
         
            <a href="<?= htmlspecialchars($baseUrl ?? '') ?>index.php?url=shop" class="bg-white text-red-900 px-6 py-3 rounded-lg font-medium hover:bg-amber-100 transition">
                Explorer notre sélection
            </a>
        </div>
    </section>

   

    <?php if (empty($featuredProducts)): ?>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-amber-100 border-l-4 border-amber-500 text-amber-700 p-4 rounded-md">
                <p class="font-semibold">Information</p>
                <p>Aucun produit en vedette pour le moment. Revenez bientôt !</p>
            </div>
        </div>
    <?php else: ?>
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Nos Sélections Exceptionnelles</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php 
                $nbProduitsAffiches = 0;
                foreach ($featuredProducts as $productData) {
                    $product = $productData;
                    if (!empty($product) && is_array($product)) {
                        $nbProduitsAffiches++;
                        $cardPath = BASE_PATH . '/app/Views/partials/product_card.php';
                        if (file_exists($cardPath)) {
                            include $cardPath;
                        }
                    }
                }
                if ($nbProduitsAffiches === 0) {
                    echo '<p class="text-red-500">Aucun produit à afficher.</p>';
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>

</body>
</html>
