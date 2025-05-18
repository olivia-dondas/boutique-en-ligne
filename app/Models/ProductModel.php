<?php
namespace App\Models;

use PDO;
use PDOException;

class ProductModel {
    private $pdo;
    private $lastQuery; 

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
            error_log("ProductModel::getFeatured() error: " . $e->getMessage());
            return [];
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
            error_log("ProductModel::getAll() error: " . $e->getMessage());
            return [];
        }
    }

    public function getProductById(int $id) {
        if ($id <= 0) {
            return false;
        }
        $sql = "SELECT p.id, p.name, p.description, p.price, p.stock, p.color, p.featured,
                       c.name as category_name
                FROM product p
                LEFT JOIN category c ON p.category_id = c.id
                WHERE p.id = :id";
        $this->lastQuery = $sql;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $productData ?: false;
    }

    private function buildFilteredQuery(array $filters, bool $countOnly = false): array {
        $sqlBase = $countOnly 
            ? "SELECT COUNT(DISTINCT p.id) as total " 
            : "SELECT DISTINCT p.id, p.name, p.description, p.price, p.stock, p.featured, p.category_id, c.name as category_name, COALESCE(pi.image_url, 'assets/images/default-wine.jpg') as image_url ";

        // Ajoute la jointure sur product_image
        $sqlFrom = "FROM product p 
                    LEFT JOIN category c ON p.category_id = c.id 
                    LEFT JOIN product_image pi ON p.id = pi.product_id ";

        $whereClauses = [];
        $params = [];

        if (!empty($filters['category'])) {
            $whereClauses[] = "p.category_id = :category_id";
            $params[':category_id'] = $filters['category'];
        }
        if (!empty($filters['region'])) {
            $whereClauses[] = "p.region_id = :region_id";
            $params[':region_id'] = $filters['region'];
        }
        if (!empty($filters['grape'])) {
            $whereClauses[] = "p.grape_id = :grape_id";
            $params[':grape_id'] = $filters['grape'];
        }
        if (isset($filters['price_min']) && $filters['price_min'] !== null) {
            $whereClauses[] = "p.price >= :price_min";
            $params[':price_min'] = $filters['price_min'];
        }
        if (isset($filters['price_max']) && $filters['price_max'] !== null) {
            $whereClauses[] = "p.price <= :price_max";
            $params[':price_max'] = $filters['price_max'];
        }

        $sqlWhere = "";
        if (!empty($whereClauses)) {
            $sqlWhere = "WHERE " . implode(" AND ", $whereClauses) . " ";
        }

        $sql = $sqlBase . $sqlFrom . $sqlWhere;

        if (!$countOnly) {
            $sql .= "ORDER BY p.name ASC ";
            if (isset($filters['per_page']) && isset($filters['page'])) {
                $offset = ((int)$filters['page'] - 1) * (int)$filters['per_page'];
                $sql .= "LIMIT :offset, :limit_per_page";
                $params[':offset'] = $offset;
                $params[':limit_per_page'] = (int)$filters['per_page'];
            }
        }
        
        $this->lastQuery = $sql . " -- Params: " . json_encode($params);
        return ['sql' => $sql, 'params' => $params];
    }

    public function getFilteredProducts($filters) {
        try {
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

            // Filtre par prix min
            if (isset($filters['price_min']) && $filters['price_min'] !== '' && is_numeric($filters['price_min'])) {
                $sql .= " AND p.price >= :price_min";
                $params[':price_min'] = (float)$filters['price_min'];
            }

            // Filtre par prix max
            if (isset($filters['price_max']) && $filters['price_max'] !== '' && is_numeric($filters['price_max'])) {
                $sql .= " AND p.price <= :price_max";
                $params[':price_max'] = (float)$filters['price_max'];
            }

            // Pagination
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)($filters['per_page'] ?? 12);
            $params[':offset'] = ((int)($filters['page'] ?? 1) - 1) * (int)($filters['per_page'] ?? 12);

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

    public function countFilteredProducts(array $filters): int {
        $sql = "SELECT COUNT(*) as total FROM product p WHERE 1=1";
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

        // Filtre par prix min
        if (isset($filters['price_min']) && $filters['price_min'] !== '' && is_numeric($filters['price_min'])) {
            $sql .= " AND p.price >= :price_min";
            $params[':price_min'] = (float)$filters['price_min'];
        }

        // Filtre par prix max
        if (isset($filters['price_max']) && $filters['price_max'] !== '' && is_numeric($filters['price_max'])) {
            $sql .= " AND p.price <= :price_max";
            $params[':price_max'] = (float)$filters['price_max'];
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function getLastQuery(): ?string {
        return $this->lastQuery;
    }
}

