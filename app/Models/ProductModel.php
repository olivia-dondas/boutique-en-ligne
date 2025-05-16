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
            : "SELECT DISTINCT p.id, p.name, p.description, p.price, p.stock, p.featured, p.category_id, c.name as category_name ";
        
        $sqlFrom = "FROM product p LEFT JOIN category c ON p.category_id = c.id ";
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
        if (isset($filters['price_min']) && $filters['price_min'] > 0) {
            $whereClauses[] = "p.price >= :price_min";
            $params[':price_min'] = $filters['price_min'];
        }
        if (isset($filters['price_max']) && $filters['price_max'] > 0 && $filters['price_max'] >= ($filters['price_min'] ?? 0)) {
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

    public function getFilteredProducts(array $filters): array {
        $queryData = $this->buildFilteredQuery($filters, false);
        $stmt = $this->pdo->prepare($queryData['sql']);
        foreach ($queryData['params'] as $key => &$val) {
            if (is_int($val)) {
                $stmt->bindParam($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $val);
            }
        }
        unset($val);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countFilteredProducts(array $filters): int {
        $queryData = $this->buildFilteredQuery($filters, true);
        $stmt = $this->pdo->prepare($queryData['sql']);
        foreach ($queryData['params'] as $key => &$val) {
            if (is_int($val)) {
                $stmt->bindParam($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $val);
            }
        }
        unset($val);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function getLastQuery(): ?string {
        return $this->lastQuery;
    }
}

$cardPath = BASE_PATH . '/app/Views/partials/product_card.php';
if (file_exists($cardPath)) {
    include $cardPath; 
} else {
    echo '<p class="text-red-500">Erreur: Carte produit non trouvée.</p>';
}
