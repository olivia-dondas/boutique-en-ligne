<div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
    <a href="/product/<?= $product['id'] ?>">
        <img src="<?= BASE_URL . (!empty($product['image_url']) ? ltrim($product['image_url'], '/') : 'assets/images/default-wine.jpg') ?>"
             alt="<?= htmlspecialchars($product['name']) ?>"
             class="w-full h-48 object-cover">
        <div class="p-4">
            <h3 class="font-bold text-lg text-gray-900"><?= htmlspecialchars($product['name']) ?></h3>
            <p class="text-red-900 font-bold mt-2"><?= number_format($product['price'], 2) ?> €</p>
        </div>
    </a>
</div>