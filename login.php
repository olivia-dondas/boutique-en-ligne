<?php
session_start();
require_once 'config.php'; 

$message = '';

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
        
        header('Location: profil.php');
        exit();
    } else {
        $message = 'Incorrect email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - Bibine Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Bibine Connexion</h2>

<?php if (!empty($message)) : ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="post" action="">
    <input type="email" name="email" placeholder="email" required><br>
    <input type="password" name="password" placeholder="Mot de Passe" required><br>
    <button type="submit">Connexion</button>
</form>

<p>Créer votre Compte? <a href="register.php">Inscris-toi</a></p>

</body>
</html>
