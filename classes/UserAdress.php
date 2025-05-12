<?php
class UserAddress {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO user_address 
            (user_id, type, street, city, postcode, country, is_default) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['user_id'],
            $data['type'],
            $data['street'],
            $data['city'],
            $data['postcode'],
            $data['country'],
            $data['is_default'] ? 1 : 0
        ]);
    }
}