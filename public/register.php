<?php


require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Désactiver le cache pour les requêtes AJAX
header("Cache-Control: no-cache, must-revalidate");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    try {
        // Validation des données
        $requiredFields = ['last_name', 'first_name', 'birth_date', 'address', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception('Tous les champs sont obligatoires.');
            }
        }

        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $address = htmlspecialchars(trim($_POST['address']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $birth_date = $_POST['birth_date'];
        
        if (!$email) {
            throw new Exception('Email invalide.');
        }

        // Vérification de l'âge (18 ans minimum)
        $today = new DateTime();
        $dob = new DateTime($birth_date);
        if ($today->diff($dob)->y < 18) {
            throw new Exception('Vous devez avoir au moins 18 ans pour vous inscrire.');
        }

        // Vérification de l'email existant
        $check = $pdo->prepare('SELECT id FROM user WHERE email = ?');
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            throw new Exception('Cet email est déjà utilisé.');
        }

        // Hash du mot de passe
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Insertion dans la base
        $stmt = $pdo->prepare('
            INSERT INTO user 
            (last_name, first_name, email, password, birth_date, role, created_at) 
            VALUES (?, ?, ?, ?, ?, "user", NOW())
        ');
        
        if ($stmt->execute([$last_name, $first_name, $email, $password, $birth_date])) {
            // Insertion de l'adresse
            $userId = $pdo->lastInsertId();
            $addressStmt = $pdo->prepare('
                INSERT INTO user_address 
                (user_id, type, street, city, postcode, country, is_default) 
                VALUES (?, "shipping", ?, "", "", "France", 1)
            ');
            $addressStmt->execute([$userId, $address]);
            
            $response = [
                'success' => true,
                'message' => 'Inscription réussie! Redirection...',
                'redirect' => '../public/login.php'
            ];
        } else {
            throw new Exception('Erreur lors de l\'inscription.');
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }

    // Retour JSON pour les requêtes AJAX
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    
    // Fallback pour non-JS
    $message = $response['message'];

    echo "<pre>"; print_r($_POST); echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Bibine</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <script src="../assets/js/auth.js" defer></script>
</head>
<body>
<?php include '../templates/header.php'; ?>
    <div class="auth-container">
        <h2>Créer un compte</h2>
        
        <div id="message" class="<?= !empty($message) ? 'show' : '' ?>">
            <?= $message ?? '' ?>
        </div>

        <form id="registerForm" method="post">
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Nom" required 
                       value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <input type="text" name="first_name" placeholder="Prénom" required
                       value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <input type="date" name="birth_date" required
                       value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>">
                <small>Vous devez avoir 18 ans ou plus</small>
            </div>
            
            <div class="form-group">
                <input type="text" name="address" placeholder="Adresse complète" required
                       value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Mot de passe (8 caractères min)" required minlength="8">
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>

        <p class="auth-link">
            Déjà un compte ? <a href="../public/login.php">Se connecter</a>
        </p>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>

</html>