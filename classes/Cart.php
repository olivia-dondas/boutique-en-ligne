<?php
class Cart {
    public function isEmpty() {
        // Implémentation temporaire
        return empty($_SESSION['cart'] ?? []);
    }
    
    public function getItems() {
        // Retourne des données fictives pour le développement
        return $_SESSION['cart'] ?? [
            ['id' => 1, 'name' => 'Produit 1', 'price' => 10],
            ['id' => 2, 'name' => 'Produit 2', 'price' => 20]
        ];
    }
}