<?php
require '../../config.php';
$db = new PDO("mysql:host=localhost;dbname=ma_bdd", "user", "password");

// Récupère les filtres
$category = $_GET['category'] ?? null;
$price_min = $_GET['price_min'] ?? 0;
$price_max = $_GET['price_max'] ?? 1000;

// Requête SQL filtrée
$sql = "SELECT * FROM products WHERE price BETWEEN ? AND ?";
$params = [$price_min, $price_max];

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/shop.css">
</head>
<body>
    <?php include 'filters.php'; ?>
    
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <?php include 'product-card.php'; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>