<?php
require_once __DIR__.'/../../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ".BASE_URL."/login");
    exit;
}

echo "<h1>Mon Compte</h1>";
echo "<p>Bienvenue, ".htmlspecialchars($_SESSION['first_name'])." !</p>";
echo '<p><a href="'.BASE_URL.'/panier">Voir mon panier</a></p>';
echo '<p><a href="?logout">Déconnexion</a></p>';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ".BASE_URL."/login");
}
?>