<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=olivia-dondas_bibine", "root", "root");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}