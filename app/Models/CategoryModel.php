<?php
namespace App\Models;

use PDO;

class CategoryModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT id, name FROM category ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}

?>
