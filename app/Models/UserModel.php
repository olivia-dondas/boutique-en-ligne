<?php
namespace App\Models;

use PDO; // Juste PDO, pas PDOException sauf si vous faites un try/catch spécifique

class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

/*************  ✨ Windsurf Command ⭐  *************/
/*******  55481d30-59d3-4d9b-9317-a30c5f08311e  *******/
    public function findByEmail(string $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(); // Retourne un array ou false
    }

    public function createUser(string $firstName, string $lastName, string $email, string $birthDate, string $password, string $role = 'client'): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare(
            "INSERT INTO user (first_name, last_name, email, password, birth_date, role, created_at) 
             VALUES (:first_name, :last_name, :email, :password, :birth_date, :role, NOW())"
        );
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':birth_date', $birthDate); // Assurez-vous que le format de date est YYYY-MM-DD
        $stmt->bindParam(':role', $role);
        
        try {
            return $stmt->execute();
        } catch (\PDOException $e) { // Type hint complet pour PDOException
            error_log("Erreur UserModel::createUser: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserById(int $id) {
        if ($id <= 0) {
            return false;
        }
        $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, role, birth_date FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $userData ?: false; // Retourne l'array si trouvé, sinon false
    }
}
// Pas de balise PHP de fermeture ici
