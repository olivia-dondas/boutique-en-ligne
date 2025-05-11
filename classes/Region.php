<?php
// classes/Region.php
require_once __DIR__ . '/Database.php';

class Region {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM region ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Region::getAll() error: " . $e->getMessage());
            return [];
        }
    }
}