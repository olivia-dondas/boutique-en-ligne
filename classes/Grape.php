<?php
// classes/Grape.php
require_once __DIR__ . '/Database.php';

class Grape {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM grape ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Grape::getAll() error: " . $e->getMessage());
            return [];
        }
    }
}