<?php
require_once __DIR__ . '/Database.php';
class Product {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    public function getFeatured($limit = 4) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.*, pi.image_url 
                FROM product p
                LEFT JOIN product_image pi ON p.id = pi.product_id
                WHERE p.featured = 1
                ORDER BY p.created_at DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getFeatured(): " . $e->getMessage());
            return [];
        }
    }

    public function setFeaturedStatus($productId, $status = 1) {
        $stmt = $this->pdo->prepare("
            UPDATE product 
            SET featured = :status 
            WHERE id = :productId
        ");
        $stmt->bindValue(':status', (int)$status, PDO::PARAM_INT);
        $stmt->bindValue(':productId', (int)$productId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT p.*, pi.image_url 
            FROM product p
            LEFT JOIN product_image pi ON p.id = pi.product_id
            ORDER BY p.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>