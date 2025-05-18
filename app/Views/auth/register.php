<?php
// app/Views/auth/register.php
require_once BASE_PATH . '/app/Views/layouts/header.php';
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Inscription';
$pageTitle = $siteName . " - Inscription";
?>

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer un compte</h2>
    <div id="message" class="mb-4 text-sm text-red-600 hidden"></div>
    <form id="registerForm" class="space-y-5" autocomplete="off">
        <div>
            <label for="first_name" class="block text-gray-700 font-medium mb-1">Prénom</label>
            <input type="text" name="first_name" id="first_name" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="last_name" class="block text-gray-700 font-medium mb-1">Nom</label>
            <input type="text" name="last_name" id="last_name" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="birth_date" class="block text-gray-700 font-medium mb-1">Date de naissance</label>
            <input type="date" name="birth_date" id="birth_date" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="address" class="block text-gray-700 font-medium mb-1">Adresse</label>
            <input type="text" name="address" id="address" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="password" class="block text-gray-700 font-medium mb-1">Mot de passe</label>
            <input type="password" name="password" id="password" minlength="6" required
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="password_confirm" class="block text-gray-700 font-medium mb-1">Confirmer le mot de passe</label>
            <input type="password" name="password_confirm" id="password_confirm" minlength="6" required
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded font-semibold hover:bg-indigo-700 transition">
            S'inscrire
        </button>
    </form>
    <p class="mt-6 text-center text-sm">
        Déjà un compte ?
        <a href="<?= htmlspecialchars($baseUrl ?? '') ?>auth/login" class="text-indigo-600 hover:underline">
            Connectez-vous ici
        </a>
    </p>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
