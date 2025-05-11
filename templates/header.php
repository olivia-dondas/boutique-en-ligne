<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-white shadow w-full">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-indigo-600"><?= SITE_NAME ?></a>
            
            <div class="flex items-center space-x-4">
                <a href="<?= BASE_URL ?>/pages/cart.php" class="relative">
                    🛒 Panier
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                </a>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>/pages/account/" class="bg-gray-200 px-3 py-1 rounded">Mon compte</a>
                    <a href="<?= BASE_URL ?>/process/logout.php" class="text-gray-600">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/login.php" class="text-gray-600">Connexion</a>
                    <a href="<?= BASE_URL ?>/register.php" class="bg-blue-500 text-white px-4 py-2 rounded">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="flex-grow w-full px-4 py-8">