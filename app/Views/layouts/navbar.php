<?php
// Vérifie si l'utilisateur est connecté (à adapter selon votre système d'authentification)
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && ($_SESSION['user_role'] ?? '') === 'admin';
?>

<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo / Nom de la boutique -->
            <div class="flex-shrink-0">
                <a href="<?= BASE_URL ?>" class="flex items-center">
                    <span class="text-xl font-bold text-gray-800">Bibine</span>
                </a>
            </div>

            <!-- Liens principaux - Visible sur desktop -->
            <div class="hidden md:flex space-x-8">
                <a href="<?= BASE_URL ?>/shop" 
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Boutique
                </a>
                
                <?php if ($isAdmin): ?>
                <a href="<?= BASE_URL ?>/admin" 
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Admin
                </a>
                <?php endif; ?>
                
                <a href="<?= BASE_URL ?>/contact" 
                   class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                    Contact
                </a>
            </div>

            <!-- Icônes de droite -->
            <div class="flex items-center space-x-4">
                <!-- Recherche (icône seulement) -->
                <button class="p-2 text-gray-600 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Compte utilisateur -->
                <div class="relative">
                    <a href="<?= $isLoggedIn ? BASE_URL.'/mon-compte' : BASE_URL.'/login' ?>" 
                       class="p-2 text-gray-600 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>

                <!-- Panier avec badge -->
                <div class="relative">
                    <a href="<?= BASE_URL ?>/panier" class="p-2 text-gray-600 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?= $_SESSION['cart_count'] ?? 0 ?>
                        </span>
                    </a>
                </div>

                <!-- Menu mobile (burger) -->
                <button class="md:hidden p-2 text-gray