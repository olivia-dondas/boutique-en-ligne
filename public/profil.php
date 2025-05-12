<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../src/config.php'; // Inclure le fichier de configuration

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo 'Session utilisateur non définie.';
    header('Location: ../public/login.php'); 
    exit();
}

// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare('SELECT first_name, last_name, email, birth_date, role, created_at FROM user WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo 'Utilisateur introuvable.';
        exit();
    }
} catch (PDOException $e) {
    echo 'Erreur lors de la récupération des données : ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - Wine Shop</title>
    <link rel="stylesheet" href="../style/login.css"> <!-- Chemin mis à jour -->
</head>
<body>

<h2>Mon Profil</h2>

<div class="profile">
    <p><strong>Prénom :</strong> <?= htmlspecialchars($user['first_name']) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($user['last_name']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Date de naissance :</strong> <?= htmlspecialchars($user['birth_date']) ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></p>
    <p><strong>Date d'inscription :</strong> <?= htmlspecialchars($user['created_at']) ?></p>
</div>

<a href="../public/logout.php">Se déconnecter</a> <!-- Chemin mis à jour -->

</body>
</html>