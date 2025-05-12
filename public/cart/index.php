<?php
require_once __DIR__ . '/../../config/autoload.php';
require_once __DIR__.'/../../config/config.php';

$cart = new Cart();
$cartItems = $cart->getItems();
$total = $cart->getTotal();

include __DIR__.'/../../templates/header.php';
?>

<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Votre Panier</h1>

    <?php if (empty($cartItems)): ?>
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg mb-4">Votre panier est vide</p>
            <a href="<?= BASE_URL ?>/shop" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Continuer vos achats
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des produits -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-full w-full object-contain" 
                                                 src="<?= htmlspecialchars($item['image_url'] ?? '/assets/images/default-product.jpg') ?>" 
                                                 alt="<?= htmlspecialchars($item['name']) ?>">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($item['name']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= number_format($item['price'], 2) ?> €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="/cart/update" method="POST" class="flex items-center">
                                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" min="1" max="99" 
                                               value="<?= $item['quantity'] ?>" 
                                               class="w-20 px-2 py-1 border rounded">
                                        <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?= number_format($item['price'] * $item['quantity'], 2) ?> €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="/cart/remove" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Récapitulatif -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium mb-4">Récapitulatif</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Sous-total</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Livraison</span>
                            <span>Gratuite</span>
                        </div>
                        <div class="border-t pt-3 mt-3 flex justify-between font-bold">
                            <span>Total</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </div>
                    </div>

                    <a href="<?= BASE_URL ?>/cart/checkout" 
                       class="mt-6 w-full bg-indigo-600 text-white py-3 px-4 rounded hover:bg-indigo-700 transition-colors block text-center">
                        Passer la commande
                    </a>

                    <a href="<?= BASE_URL ?>/shop" 
                       class="mt-4 w-full bg-white text-indigo-600 py-3 px-4 rounded border border-indigo-600 hover:bg-indigo-50 transition-colors block text-center">
                        Continuer vos achats
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__.'/../../templates/footer.php'; ?>