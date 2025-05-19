

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
<?php
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && ($_SESSION['user_role'] ?? '') === 'admin';
?>
<header class="bg-white shadow w-full">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?= BASE_URL ?>" class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600"><?= SITE_NAME ?></span>
                </a>
            </div>
            <!-- Liens principaux - Desktop -->
            <div class="hidden md:flex space-x-8">
                <a href="<?= BASE_URL ?>shop"
                   class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                    Boutique
                </a>
                <?php if ($isAdmin): ?>
                    <a href="<?= BASE_URL ?>admin/products"
                       class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                        Produits
                    </a>
                    <a href="<?= BASE_URL ?>admin/orders"
                       class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                        Commandes
                    </a>
                    <a href="<?= BASE_URL ?>admin/categories"
                       class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                        Catégories
                    </a>
                <?php endif; ?>
            </div>
            <!-- Icônes de droite -->
            <div class="flex items-center space-x-4">
                <!-- Panier -->
                <div class="relative">
                    <a href="<?= BASE_URL ?>panier" class="p-2 text-gray-600 hover:text-indigo-600">
                        <span>🛒</span>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?= $_SESSION['cart_count'] ?? 0 ?>
                        </span>
                    </a>
                </div>
                <!-- Compte utilisateur -->
                <?php if($isLoggedIn): ?>
                    <a href="<?= BASE_URL ?>mon-compte"
                       class="bg-gray-200 px-3 py-1 rounded text-sm hover:bg-gray-300">
                        Mon compte
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=auth/logout"
                       class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>index.php?url=auth/login"
                       class="text-gray-600 text-sm hover:text-indigo-600">
                        Connexion
                    </a>
                    <a href="<?= BASE_URL ?>auth/register"
                       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                        Inscription
                    </a>
                <?php endif; ?>
                <!-- Menu mobile (burger) -->
                <button class="md:hidden p-2 text-gray-600 hover:text-indigo-600 focus:outline-none"
                        id="mobile-menu-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Menu mobile -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="<?= BASE_URL ?>shop"
               class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600">
                Boutique
            </a>
            <?php if ($isAdmin): ?>
                <a href="<?= BASE_URL ?>admin/products"
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600">
                    Produits
                </a>
                <a href="<?= BASE_URL ?>admin/orders"
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600">
                    Commandes
                </a>
                <a href="<?= BASE_URL ?>admin/categories"
                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-indigo-600">
                    Catégories
                </a>
            <?php endif; ?>
            <div class="border-t border-gray-200 pt-4 pb-3">
                <?php if ($isLoggedIn): ?>
                    <p class="px-3 py-2 text-sm font-medium text-gray-500">
                        Connecté en tant que <?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?>
                    </p>
                    <a href="<?= BASE_URL ?>mon-compte"
                       class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Mon compte
                    </a>
                    <a href="<?= BASE_URL ?>index.php?url=auth/logout"
                       class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>index.php?url=auth/login"
                       class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Connexion
                    </a>
                    <a href="<?= BASE_URL ?>auth/register"
                       class="block px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<main class="flex-grow w-full px-4 py-8">
<!-- Le contenu principal de votre page viendra ici -->
