<?php
// Démarrer la session si elle n'est pas active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';

// Traitement de la connexion AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $response = ['success' => false, 'message' => ''];

    // Vérifier le token CSRF (protection contre les attaques)
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $response['message'] = 'Erreur de sécurité. Veuillez rafraîchir la page.';
        echo json_encode($response);
        exit();
    }

    // Valider les champs email/mot de passe
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $response['message'] = 'Tous les champs sont obligatoires.';
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        // Vérifier si l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Adresse email invalide.';
        } else {
            // Chercher l'utilisateur en base de données
            $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Vérifier le mot de passe
            if ($user && password_verify($_POST['password'], $user['password'])) {
                // Connexion réussie : stocker les données en session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];

                $response['success'] = true;
                $response['message'] = 'Connexion réussie !';
                
                // Rediriger vers la page demandée ou "/mon-compte" par défaut
                $response['redirect'] = $_SESSION['redirect_after_login'] ?? '/mon-compte';
                unset($_SESSION['redirect_after_login']);
            } else {
                $response['message'] = 'Email ou mot de passe incorrect.';
            }
        }
    }

    // Renvoyer la réponse JSON
    echo json_encode($response);
    exit();
}

// Générer un token CSRF pour le formulaire (sécurité)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Bibine Shop</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <h2>Connexion</h2>
    
    <!-- Zone d'affichage des messages d'erreur/succès -->
    <div class="message"></div>
    
    <!-- Formulaire de connexion -->
    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        
        <input type="email" name="email" placeholder="Email" autocomplete="email"><br>
        <input type="password" name="password" placeholder="Mot de passe" autocomplete="current-password" required><br>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <p>Pas encore de compte ? <a href="<?= BASE_URL ?>/register.php">S'inscrire</a></p>

    <!-- Script pour gérer la soumission AJAX -->
    <script>
    document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const response = await fetch('', {
            method: 'POST',
            body: new FormData(e.target),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const result = await response.json();
        const messageDiv = document.querySelector('.message');
        
        // Afficher le message
        messageDiv.textContent = result.message;
        messageDiv.style.color = result.success ? 'green' : 'red';
        
        // Rediriger si succès
        if (result.success && result.redirect) {
            window.location.href = "<?= BASE_URL ?>" + result.redirect;
        }
    });
    </script>
</body>
</html>