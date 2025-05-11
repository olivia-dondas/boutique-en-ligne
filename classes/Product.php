<?php
require_once __DIR__ . '/Database.php';

class Product {
    private $pdo;
    private $lastQuery = '';

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getFeatured($limit = 4) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.*, 
                       COALESCE(pi.image_url, '/images/default-wine.jpg') AS image_url,
                       c.name AS category_name
                FROM product p
                LEFT JOIN product_image pi ON p.id = pi.product_id
                LEFT JOIN category c ON p.category_id = c.id
                WHERE p.featured = 1
                ORDER BY p.created_at DESC
                LIMIT :limit
            ");

            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Product::getFeatured() error: " . $e->getMessage());
            return [];
        }
    }

    public function setFeaturedStatus($productId, $status = 1) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE product 
                SET featured = :status 
                WHERE id = :productId
            ");
            $stmt->bindValue(':status', (int)$status, PDO::PARAM_INT);
            $stmt->bindValue(':productId', (int)$productId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Product::setFeaturedStatus() error: " . $e->getMessage());
            return false;
        }
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("
                SELECT p.*, pi.image_url 
                FROM product p
                LEFT JOIN product_image pi ON p.id = pi.product_id
                ORDER BY p.name
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getAll() error: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.*, pi.image_url 
                FROM product p
                LEFT JOIN product_image pi ON p.id = pi.product_id
                WHERE p.id = :id
            ");
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getById() error: " . $e->getMessage());
            return null;
        }
    }

    public function getAllCategories() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM category");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getAllCategories() error: " . $e->getMessage());
            return [];
        }
    }

    public function getFilteredProducts($filters) {
        try {
            // Construction de la requête de base avec jointures
            $sql = "SELECT p.*, pi.image_url, c.name AS category_name
                    FROM product p
                    LEFT JOIN product_image pi ON p.id = pi.product_id
                    LEFT JOIN category c ON p.category_id = c.id
                    WHERE 1=1";
            $params = [];

            // Filtre par catégorie
            if (!empty($filters['category'])) {
                $sql .= " AND p.category_id = :category";
                $params[':category'] = (int)$filters['category'];
            }

            // Filtre par région
            if (!empty($filters['region'])) {
                $sql .= " AND p.region_id = :region";
                $params[':region'] = (int)$filters['region'];
            }

            // Filtre par cépage
            if (!empty($filters['grape'])) {
                $sql .= " AND p.grape_id = :grape";
                $params[':grape'] = (int)$filters['grape'];
            }

            // Filtre par prix
            $sql .= " AND p.price BETWEEN :price_min AND :price_max";
            $params[':price_min'] = (float)$filters['price_min'];
            $params[':price_max'] = (float)$filters['price_max'];

            // Pagination
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)$filters['per_page'];
            $params[':offset'] = ((int)$filters['page'] - 1) * (int)$filters['per_page'];

            $this->lastQuery = $sql;

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $type);
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Product::getFilteredProducts() error: " . $e->getMessage());
            return [];
        }
    }

    public function countFilteredProducts($filters) {
        try {
            $sql = "SELECT COUNT(*) FROM product WHERE 1=1";
            $params = [];

            // Filtre par catégorie
            if (!empty($filters['category'])) {
                $sql .= " AND category_id = :category";
                $params[':category'] = (int)$filters['category'];
            }

            // Filtre par région
            if (!empty($filters['region'])) {
                $sql .= " AND region_id = :region";
                $params[':region'] = (int)$filters['region'];
            }

            // Filtre par cépage
            if (!empty($filters['grape'])) {
                $sql .= " AND grape_id = :grape";
                $params[':grape'] = (int)$filters['grape'];
            }

            // Filtre par prix
            $sql .= " AND price BETWEEN :price_min AND :price_max";
            $params[':price_min'] = (float)$filters['price_min'];
            $params[':price_max'] = (float)$filters['price_max'];

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $type);
            }
            $stmt->execute();

            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            error_log("Product::countFilteredProducts() error: " . $e->getMessage());
            return 0;
        }
    }

    public function getLastQuery() {
        return $this->lastQuery;
    }

    public function getRegions() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM region ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getRegions() error: " . $e->getMessage());
            return [];
        }
    }

    public function getGrapes() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM grape ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getGrapes() error: " . $e->getMessage());
            return [];
        }
    }
}
?>