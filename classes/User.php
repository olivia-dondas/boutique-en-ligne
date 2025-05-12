<?php
class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO user 
            (last_name, first_name, email, password, birth_date, role, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $data['last_name'],
            $data['first_name'],
            $data['email'],
            $data['password'],
            $data['birth_date'],
            $data['role']
        ]);
        
        return $this->pdo->lastInsertId();
    }
}