<?php

require_once BASE_PATH . '/app/Models/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo json_encode([
            'success' => false,
            'message' => 'Veuillez remplir tous les champs.'
        ]);
        exit;
    }

    $pdo = \App\Models\Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        // Ajoute d'autres infos si besoin

        echo json_encode([
            'success' => true,
            'message' => 'Connexion réussie !',
            'redirect' => BASE_URL // ou la page d’accueil
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.'
        ]);
    }
    exit;
}



require_once BASE_PATH . '/app/Views/layouts/header.php';
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Connectez-vous à votre compte';
$pageTitle = $siteName . " - Connexion"; // Titre spécifique pour la page de connexion
?>

<script src="<?= BASE_URL ?>assets/js/auth.js"></script>

<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6 text-center">Connexion</h2>
    
    <div id="message" class="mb-4 text-sm text-red-600 hidden"></div>

    <form id="loginForm" class="space-y-4">
        <div>
            <label for="email" class="block text-gray-700">Email :</label>
            <input type="email" name="email" id="email" required autocomplete="email"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="password" class="block text-gray-700">Mot de passe :</label>
            <input type="password" name="password" id="password" required
                   autocomplete="current-password"
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
