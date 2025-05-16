<?php
namespace App\Controllers;

use App\Models\ProductModel; // Correction ici

class HomeController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function index() {
        $featuredProducts = $this->productModel->getFeatured(4); // Utilise la propriété de la classe
        $pageTitle = "Accueil";
        $baseUrl = BASE_URL; 
        require BASE_PATH . '/app/Views/home/index.php';
    }

    // Helper pour rendre les vues (pourrait être dans un BaseController)
    protected function renderView(string $viewPath, array $data = []) {
        extract($data);
        $baseUrl = BASE_URL; 

        $headerPath = BASE_PATH . '/app/Views/layouts/header.php';
        $viewFile = BASE_PATH . '/app/Views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            error_log("HomeController::renderView - Fichier de vue NON TROUVÉ: " . $viewFile);
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                echo "Erreur critique: Fichier de vue manquant: " . htmlspecialchars($viewFile);
            } else {
                echo "Une erreur est survenue lors du chargement de la page.";
            }
            exit;
        }
        require_once $viewFile;
        require_once BASE_PATH . '/app/Views/layouts/footer.php';
    }
}

