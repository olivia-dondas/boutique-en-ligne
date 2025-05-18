<?php if (!empty($product) && is_array($product)): ?>
<?php
// Si image_url existe et n'est pas vide, on l'utilise, sinon on force le chemin complet
if (isset($product['image_url']) && !empty($product['image_url'])) {
    // Si le chemin ne commence pas par 'assets/', on l'ajoute
    $imageUrl = ltrim($product['image_url'], '/');
    if (strpos($imageUrl, 'assets/') !== 0) {
        $imageUrl = 'assets/images/' . basename($imageUrl);
    }
} else {
    $imageUrl = 'assets/images/default-wine.jpg';
}
?>
<div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
    <img src="<?= BASE_URL . $imageUrl ?>"
         alt="<?= htmlspecialchars($product['name']) ?>"
         class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="font-bold text-lg text-gray-900"><?= htmlspecialchars($product['name']) ?></h3>
        <p class="text-red-900 font-bold mt-2"><?= number_format($product['price'], 2) ?> €</p>
    </div>
</div>
<?php endif; ?>