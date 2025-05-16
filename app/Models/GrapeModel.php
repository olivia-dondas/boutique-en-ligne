<?php
namespace App\Models;

use PDO;

class GrapeModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll(): array {
        // Assurez-vous que la table s'appelle bien 'grape'
        $stmt = $this->pdo->query("SELECT id, name FROM grape ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
