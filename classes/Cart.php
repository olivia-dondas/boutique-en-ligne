<?php
require_once __DIR__ . '/../Database.php';

class Cart {
    private $pdo;
    private $items = [];

    public function __construct() {
        $this->pdo = Database::getInstance()->getPDO();
        
        // Initialiser le panier depuis la session
        $this->items = $_SESSION['cart'] ?? [];
    }

    /**
     * Ajoute un produit au panier
     */
    public function addItem($productId, $quantity = 1) {
        if (isset($this->items[$productId])) {
            $this->items[$productId] += $quantity;
        } else {
            $this->items[$productId] = $quantity;
        }
        
        $this->saveToSession();
    }

    /**
     * Met à jour la quantité d'un produit
     */
    public function updateItem($productId, $quantity) {
        if ($quantity <= 0) {
            $this->removeItem($productId);
            return;
        }
        
        $this->items[$productId] = $quantity;
        $this->saveToSession();
    }

    /**
     * Supprime un produit du panier
     */
    public function removeItem($productId) {
        unset($this->items[$productId]);
        $this->saveToSession();
    }

    /**
     * Récupère tous les items avec les détails complets des produits
     */
    public function getItems() {
        if (empty($this->items)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($this->items), '?'));
        $productIds = array_keys($this->items);
        
        $stmt = $this->pdo->prepare("
            SELECT p.*, pi.image_url 
            FROM product p
            LEFT JOIN product_image pi ON p.id = pi.product_id
            WHERE p.id IN ($placeholders)
        ");
        
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Associer les quantités
        foreach ($products as &$product) {
            $product['quantity'] = $this->items[$product['id']];
        }

        return $products;
    }

    /**
     * Calcule le total du panier
     */
    public function getTotal() {
        $items = $this->getItems();
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    /**
     * Vide complètement le panier
     */
    public function clear() {
        $this->items = [];
        $this->saveToSession();
    }

    /**
     * Sauvegarde le panier dans la session
     */
    private function saveToSession() {
        $_SESSION['cart'] = $this->items;
    }

    /**
     * Compte le nombre total d'articles dans le panier
     */
    public function countItems() {
        return array_sum($this->items);
    }
}
?>