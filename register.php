<?php

$message = '';

if (
    !empty($_POST['first_name']) &&
    !empty($_POST['last_name']) &&
    !empty($_POST['birth_date']) &&
    !empty($_POST['address']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
) {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $birth_date = $_POST['birth_date'];
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Vérification de l'âge
    $today = new DateTime();
    $dob = new DateTime($birth_date);
    $age = $today->diff($dob)->y;

    if ($age < 18) {
        $message = 'You must be at least 18 years old to register.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            $message = 'Email already registered.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (prénom, nom ,date de naissance, adresse, email, password) VALUES (?, ?, ?, ?, ?, ?)');
            if ($stmt->execute([$first_name, $last_name, $birth_date, $address, $email, $password])) {
                $message = 'Registration successful! You can now login.';
            } else {
                $message = 'Registration failed.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Register - Wine Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2> Bibine Inscription</h2>

<?php if (!empty($message)) : ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="post" action="">
    <input type="text" name="Prénom" placeholder="Prénom" required><br>
    <input type="text" name="Nom" placeholder="Nom" required><br>
    <input type="date" name="Date de Naissance" required><br>
    <input type="text" name="Adresse" placeholder="Adresse" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="Mot de passe" placeholder="Mot de Passe" required><br>
    <button type="submit">Inscription</button>
</form>

<p>Si déja un compte ? <a href="login.php">Connecte-toi</a></p>

</body>
</html>
