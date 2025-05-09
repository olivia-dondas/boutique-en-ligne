<?php
class Database {
    public static function connect() {
        $pdo = new PDO("mysql:host=localhost;dbname=olivia-dondas_bibine", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}