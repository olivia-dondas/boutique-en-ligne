<?php

namespace App\Controllers;

class AdminController
{
    // Vérifie si l'utilisateur est admin (à appeler en début de chaque méthode)
    protected function checkAdmin()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    // Liste des produits
    public function products()
    {
        $this->checkAdmin();
        $pdo = \App\Models\Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM product");
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require BASE_PATH . '/app/Views/admin/products.php';
    }

    // Liste des commandes
    public function orders()
    {
        $this->checkAdmin();
        $pdo = \App\Models\Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM `order` ORDER BY created_at DESC");
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require BASE_PATH . '/app/Views/admin/orders.php';
    }

    // Liste des catégories
    public function categories()
    {
        $this->checkAdmin();
        $pdo = \App\Models\Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM category");
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require BASE_PATH . '/app/Views/admin/categories.php';
    }
}