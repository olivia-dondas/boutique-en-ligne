<?php

require_once '../src/config.php'; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $response = ['success' => false, 'message' => ''];

    if (
        !empty($_POST['last_name']) && 
        !empty($_POST['first_name']) && 
        !empty($_POST['birth_date']) &&
        !empty($_POST['address']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password'])
    ) {
        $last_name = htmlspecialchars($_POST['last_name']); 
        $first_name = htmlspecialchars($_POST['first_name']);
        $birth_date = $_POST['birth_date'];
        $address = htmlspecialchars($_POST['address']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = 'user'; // Valeur pour le rôle

        // Vérification de l'âge
        $today = new DateTime();
        $dob = new DateTime($birth_date);
        $age = $today->diff($dob)->y;

        if ($age < 18) {
            $response['message'] = 'You must be at least 18 years old to register.';
        } else {
            $check = $pdo->prepare('SELECT id FROM user WHERE email = ?');
            $check->execute([$email]);
            if ($check->rowCount() > 0) {
                $response['message'] = 'Email déjà enregistré.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO user (last_name, first_name, email, password, birth_date, role, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
                if ($stmt->execute([$last_name, $first_name, $email, $password, $birth_date, $role])) {
                    $response['success'] = true;
                    $response['message'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
                } else {
                    $response['message'] = 'Inscription refusée.';
                }
            }
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
    <title>Register - Wine Shop</title>
    <link rel="stylesheet" href="../style/login.css"> 
</head>
<body>

<h2> Bibine Inscription</h2>

<div class="message"></div>

<form method="post" action="">
    <input type="text" name="last_name" placeholder="Nom" required><br>
    <input type="text" name="first_name" placeholder="Prénom" required><br>
    <input type="date" name="birth_date" required><br>
    <input type="text" name="address" placeholder="Adresse" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de Passe" required><br>
    <button type="submit">Inscription</button>
</form>

<p>Si déjà un compte ? <a href="../public/login.php">Connecte-toi</a></p> 

</body>
</html>