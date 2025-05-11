
<div class="filters-container bg-white p-6 rounded-lg shadow mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Filtre Texte -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                   placeholder="Nom du vin..." 
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
        </div>

        <!-- Filtre Catégories -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="category" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-800">
                <option value="">Tous les types</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Filtre Régions -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Région</label>
            <select name="region" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-800">
                <option value="">Toutes régions</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['id'] ?>" <?= ($_GET['region'] ?? '') == $region['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($region['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Filtre Prix -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
            <select name="price_range" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-800">
                <option value="">Toutes gammes</option>
                <option value="0-20" <?= ($_GET['price_range'] ?? '') == '0-20' ? 'selected' : '' ?>>Moins de 20€</option>
                <option value="20-40" <?= ($_GET['price_range'] ?? '') == '20-40' ? 'selected' : '' ?>>20-40€</option>
                <option value="40-100" <?= ($_GET['price_range'] ?? '') == '40-100' ? 'selected' : '' ?>>40-100€</option>
                <option value="100+" <?= ($_GET['price_range'] ?? '') == '100+' ? 'selected' : '' ?>>100€ et plus</option>
            </select>
        </div>

        <!-- Filtre Cépages -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cépage</label>
            <select name="grape" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-800">
                <option value="">Tous cépages</option>
                <?php foreach ($grapes as $grape): ?>
                    <option value="<?= $grape['id'] ?>" <?= ($_GET['grape'] ?? '') == $grape['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($grape['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Filtre Couleurs -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="colors[]" value="red" <?= in_array('red', $_GET['colors'] ?? []) ? 'checked' : '' ?> class="rounded border-gray-300 text-red-800 focus:ring-red-800">
                    <span class="ml-2">Rouge</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="colors[]" value="white" <?= in_array('white', $_GET['colors'] ?? []) ? 'checked' : '' ?> class="rounded border-gray-300 text-red-800 focus:ring-red-800">
                    <span class="ml-2">Blanc</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="colors[]" value="rose" <?= in_array('rose', $_GET['colors'] ?? []) ? 'checked' : '' ?> class="rounded border-gray-300 text-red-800 focus:ring-red-800">
                    <span class="ml-2">Rosé</span>
                </label>
            </div>
        </div>

        <!-- Boutons -->
        <div class="md:col-span-4 flex justify-between">
            <button type="submit" class="bg-red-800 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                Appliquer les filtres
            </button>
            <a href="?" class="text-gray-600 hover:text-red-800 self-center">
                Réinitialiser
            </a>
        </div>
    </form>
</div>