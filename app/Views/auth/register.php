<?php
require_once BASE_PATH . '/app/Models/Database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Connexion PDO via ta classe
    $pdo = \App\Models\Database::getInstance();

    // Récupération et validation des données
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthDate = $_POST['birth_date'] ?? '';
    $address = $_POST['address'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $country = $_POST['country'] ?? '';

    if (!$firstName || !$lastName || !$email || !$password || $password !== $passwordConfirm) {
        echo json_encode([
            'success' => false,
            'message' => 'Veuillez remplir tous les champs et vérifier les mots de passe.'
        ]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 1. Insertion dans user (sans address)
        $stmt = $pdo->prepare("INSERT INTO user (first_name, last_name, email, birth_date, password) VALUES (?, ?, ?, ?, ?)");
        $ok = $stmt->execute([$firstName, $lastName, $email, $birthDate, $passwordHash]);

        if ($ok) {
            // 2. Récupère l'id du nouvel utilisateur
            $userId = $pdo->lastInsertId();

            // 3. Insertion dans user_address (adresse principale)
            $stmt2 = $pdo->prepare("INSERT INTO user_address (user_id, type, street, city, postcode, country, is_default) VALUES (?, 'shipping', ?, ?, ?, ?, 1)");
            $stmt2->execute([$userId, $street, $city, $postcode, $country]);

            echo json_encode([
                'success' => true,
                'message' => 'Inscription réussie !',
                'redirect' => BASE_URL . 'auth/login'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de l\'inscription.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur SQL : ' . $e->getMessage()
        ]);
    }
    exit;
}

// app/Views/auth/register.php
require_once BASE_PATH . '/app/Views/layouts/header.php';
$siteName = defined('SITE_NAME') ? SITE_NAME : 'Inscription';
$pageTitle = $siteName . " - Inscription";
?>
<script src="<?= BASE_URL ?>assets/js/auth.js"></script>


<div class="max-w-lg mx-auto bg-white p-8 rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Créer un compte</h2>
    <div id="message" class="mb-4 text-sm text-red-600 hidden"></div>
    <form id="registerForm" class="space-y-5" autocomplete="off">
        <div>
            <label for="first_name" class="block text-gray-700 font-medium mb-1">Prénom</label>
            <input type="text" name="first_name" id="first_name" required autocomplete="given-name"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="last_name" class="block text-gray-700 font-medium mb-1">Nom</label>
            <input type="text" name="last_name" id="last_name" required autocomplete="family-name"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" required autocomplete="email"
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="birth_date" class="block text-gray-700 font-medium mb-1">Date de naissance</label>
            <input type="date" name="birth_date" id="birth_date" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="street" class="block text-gray-700 font-medium mb-1">Adresse (rue)</label>
            <input type="text" name="street" id="street" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="city" class="block text-gray-700 font-medium mb-1">Ville</label>
            <input type="text" name="city" id="city" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="postcode" class="block text-gray-700 font-medium mb-1">Code postal</label>
            <input type="text" name="postcode" id="postcode" required
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="country" class="block text-gray-700 font-medium mb-1">Pays</label>
            <input type="text" name="country" id="country" value="France" required
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
