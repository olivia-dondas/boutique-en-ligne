<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $response = ['success' => false, 'message' => ''];

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];

            $response['success'] = true;
            $response['message'] = 'Connexion réussie.';
        } else {
            $response['message'] = 'Email ou Mot de passe Incorrect.';
        }
    } else {
        $response['message'] = 'Tous les champs sont obligatoires.';
    }

    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - Bibine Shop</title>
    <link rel="stylesheet" href="../assets/css/login.css"> 
</head>
<body>

<h2>Bibine Connexion</h2>

<div class="message"></div>

<form method="post" action="">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de Passe" required><br>
    <button type="submit">Connexion</button>
</form>

<p>Créer votre Compte? <a href="../public/register.php">Inscris-toi</a></p> <!-- Chemin mis à jour -->

</body>
</html>