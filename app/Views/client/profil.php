<?php
require_once __DIR__ . '/../../../config.php';
require_once BASE_PATH . '/app/Models/Database.php';
require_once BASE_PATH . '/app/Views/layouts/header.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'auth/login');
    exit;
}

$pdo = \App\Models\Database::getInstance();

// Récupération des données utilisateur
$userQuery = $pdo->prepare("
    SELECT u.*, 
           ua.street, ua.city, ua.postcode, ua.country 
    FROM user u
    LEFT JOIN user_address ua ON u.id = ua.user_id AND ua.is_default = 1
    WHERE u.id = ?
");
$userQuery->execute([$_SESSION['user_id']]);
$user = $userQuery->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur non trouvé");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité");
    }

    // Nettoyage des données
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = preg_replace('/[^0-9+]/', '', $_POST['phone'] ?? '');
    $birthDate = $_POST['birth_date'];
    $street = htmlspecialchars(trim($_POST['street']));
    $city = htmlspecialchars(trim($_POST['city']));
    $postcode = htmlspecialchars(trim($_POST['postcode']));
    $country = htmlspecialchars(trim($_POST['country']));

    // Validation des champs requis
    $requiredFields = ['first_name', 'last_name', 'email', 'birth_date', 'street', 'city', 'postcode', 'country'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Le champ $field est requis";
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
    }

    if (!$email) {
        $_SESSION['error'] = "Email invalide";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    // Transaction pour garantir l'intégrité des données
    $pdo->beginTransaction();
    try {
        // Mise à jour utilisateur
        $updateUser = $pdo->prepare("
            UPDATE user SET 
                first_name = ?, 
                last_name = ?, 
                email = ?, 
                birth_date = ?,
                phone = ?
            WHERE id = ?
        ");
        $updateUser->execute([$firstName, $lastName, $email, $birthDate, $phone, $_SESSION['user_id']]);

        // Mise à jour adresse
        if ($user['street']) {
            // Adresse existante - mise à jour
            $updateAddress = $pdo->prepare("
                UPDATE user_address SET 
                    street = ?, 
                    city = ?, 
                    postcode = ?, 
                    country = ?
                WHERE user_id = ? AND is_default = 1
            ");
            $updateAddress->execute([$street, $city, $postcode, $country, $_SESSION['user_id']]);
        } else {
            // Nouvelle adresse - création
            $insertAddress = $pdo->prepare("
                INSERT INTO user_address 
                (user_id, type, street, city, postcode, country, is_default)
                VALUES (?, 'shipping', ?, ?, ?, ?, 1)
            ");
            $insertAddress->execute([$_SESSION['user_id'], $street, $city, $postcode, $country]);
        }

        $pdo->commit();
        $_SESSION['success'] = "Profil mis à jour avec succès";
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Génération du token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Mon profil</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        
        <div class="mb-4">
            <label for="first_name" class="block font-medium">Prénom</label>
            <input type="text" name="first_name" id="first_name" required
                   value="<?= htmlspecialchars($user['first_name'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="last_name" class="block font-medium">Nom</label>
            <input type="text" name="last_name" id="last_name" required
                   value="<?= htmlspecialchars($user['last_name'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" required
                   value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="phone" class="block font-medium">Téléphone</label>
            <input type="tel" name="phone" id="phone"
                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="birth_date" class="block font-medium">Date de naissance</label>
            <input type="date" name="birth_date" id="birth_date" required
                   value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="street" class="block font-medium">Adresse</label>
            <input type="text" name="street" id="street" required
                   value="<?= htmlspecialchars($user['street'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="city" class="block font-medium">Ville</label>
            <input type="text" name="city" id="city" required
                   value="<?= htmlspecialchars($user['city'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="postcode" class="block font-medium">Code postal</label>
            <input type="text" name="postcode" id="postcode" required
                   value="<?= htmlspecialchars($user['postcode'] ?? '') ?>"
                   class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="country" class="block font-medium">Pays</label>
            <select name="country" id="country" required class="w-full px-3 py-2 border rounded">
                <option value="">Sélectionnez...</option>
                <option value="France" <?= ($user['country'] ?? '') === 'France' ? 'selected' : '' ?>>France</option>
                <option value="Belgique" <?= ($user['country'] ?? '') === 'Belgique' ? 'selected' : '' ?>>Belgique</option>
                <option value="Suisse" <?= ($user['country'] ?? '') === 'Suisse' ? 'selected' : '' ?>>Suisse</option>
                <option value="Luxembourg" <?= ($user['country'] ?? '') === 'Luxembourg' ? 'selected' : '' ?>>Luxembourg</option>
            </select>
        </div>
        
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>