<?php
namespace App\Models;

use PDO;

class RegionModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll(): array {
        // Assurez-vous que la table s'appelle bien 'region'
        $stmt = $this->pdo->query("SELECT id, name FROM region ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
