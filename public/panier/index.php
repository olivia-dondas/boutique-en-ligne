<?php
require_once __DIR__.'/../../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = '/panier';
    header("Location: ".BASE_URL."/login");
    exit;
}

require_once __DIR__.'/../../classes/Cart.php';
$cart = new Cart();

echo "<h1>Mon Panier</h1>";

if ($cart->isEmpty()) {
    echo "<p>Votre panier est vide</p>";
} else {
    echo "<ul>";
    foreach ($cart->getItems() as $item) {
        echo "<li>".htmlspecialchars($item['name'])."</li>";
    }
    echo "</ul>";
}
?>