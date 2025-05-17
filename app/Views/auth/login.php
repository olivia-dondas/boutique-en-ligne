<?php
require_once BASE_PATH . '/app/Views/layouts/header.php';
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Connectez-vous à votre compte';
$pageTitle = $siteName . " - Connexion"; // Titre spécifique pour la page de connexion
?>

<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6 text-center">Connexion</h2>
    
    <div id="message" class="mb-4 text-sm text-red-600 hidden"></div>

    <form id="loginForm" class="space-y-4">
        <div>
            <label for="email" class="block text-gray-700">Email :</label>
            <input type="email" name="email" id="email" required 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="password" class="block text-gray-700">Mot de passe :</label>
            <input type="password" name="password" id="password" required 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
            Se connecter
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        Pas encore de compte ? 
        <a href="<?= htmlspecialchars($baseUrl ?? '') ?>index.php?url=auth/register" 
           class="text-indigo-600 hover:underline">
            Inscrivez-vous ici
        </a>
    </p>
</div>
    
<?php
require_once BASE_PATH . '/app/Views/layouts/footer.php';
?>
