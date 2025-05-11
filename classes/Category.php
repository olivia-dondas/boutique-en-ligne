<?php
// classes/Category.php
require_once __DIR__ . '/Database.php';

class Category {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM category ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Category::getAll() error: " . $e->getMessage());
            return [];
        }
    }
}