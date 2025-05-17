<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\RegionModel;  
use App\Models\GrapeModel;  

class ShopController {
    private $productModel;
    private $categoryModel;
    private $regionModel;   
    private $grapeModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->regionModel = new RegionModel();     
        $this->grapeModel = new GrapeModel();      
    }
    

    
    public function index() {
         $currentPage = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12; // Nombre de produits par page

        // Nettoyage et récupération des filtres depuis GET
        $filters = [
            'category'   => isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null,
            'region'     => isset($_GET['region']) && $_GET['region'] !== '' ? (int)$_GET['region'] : null,
            'grape'      => isset($_GET['grape']) && $_GET['grape'] !== '' ? (int)$_GET['grape'] : null,
            'price_min'  => isset($_GET['price_min']) && $_GET['price_min'] !== '' ? (float)$_GET['price_min'] : null,
            'price_max'  => isset($_GET['price_max']) && $_GET['price_max'] !== '' ? (float)$_GET['price_max'] : null,
            'page'       => isset($_GET['page']) ? (int)$_GET['page'] : 1,
            'per_page'   => 12
        ];
        // Assurer que price_max n'est pas inférieur à price_min si les deux sont définis
        if ($filters['price_max'] > 0 && $filters['price_max'] < $filters['price_min']) {
            $filters['price_max'] = $filters['price_min']; // Ou une autre logique
        }
         try {
            $products = $this->productModel->getFilteredProducts($filters);
            $totalProducts = $this->productModel->countFilteredProducts($filters);
            $totalPages = ($perPage > 0) ? ceil($totalProducts / $perPage) : 1;
            
            $categories = $this->categoryModel->getAll();
            $regions = $this->regionModel->getAll();     
            $grapes = $this->grapeModel->getAll();       

        } catch (\Exception $e) { // Utilisez \Exception pour attraper toutes les exceptions PHP
            error_log("ShopController Error: " . $e->getMessage());
            // Afficher une page d'erreur plus conviviale en production
            $this->renderView('errors/500', ['pageTitle' => 'Erreur de la Boutique', 'errorMessage' => $e->getMessage()]);
            return;
        }

        $dataToView = [
            'products' => $products,
            'categories' => $categories,
            'regions' => $regions,               
            'grapes' => $grapes,                  
            'filters' => $filters, // Pour pré-remplir le formulaire
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
            'pageTitle' => 'Notre Boutique de Vins'
        ];

        error_log('GET : ' . print_r($_GET, true));
        error_log('FILTERS : ' . print_r($filters, true));
        error_log('SQL : ' . $this->productModel->getLastQuery());

        require BASE_PATH . '/app/Views/shop/index.php';
    }

    
    public function show(int $id = 0) {
        if ($id <= 0) {
            // Gérer ID invalide, par exemple rediriger vers la page shop ou afficher une erreur 404
            error_log("ShopController::show() - ID de produit invalide ou manquant: " . $id);
            // Vous pourriez avoir une méthode pour afficher une page 404 personnalisée
            http_response_code(404);
            $this->renderView('errors/404', ['pageTitle' => 'Produit Introuvable']); // Vue d'erreur à créer
            return;
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            error_log("ShopController::show() - Produit non trouvé pour l'ID: " . $id);
            http_response_code(404);
            $this->renderView('errors/404', ['pageTitle' => 'Produit Introuvable']); // Vue d'erreur à créer
            return;
        }

        // Passer le produit à la vue
        $this->renderView('shop/show', ['product' => $product, 'pageTitle' => $product['name']]);
    }

    protected function renderView(string $viewPath, array $data = []) {
        extract($data);
        $baseUrl = BASE_URL; 

     
       $headerPath = BASE_PATH . '/app/Views/layouts/header.php';
    
        
        $viewFile = BASE_PATH . '/app/Views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
             error_log("ShopController::renderView - Fichier de vue NON TROUVÉ: " . $viewFile);
             if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                echo "Erreur critique: Fichier de vue manquant: " . htmlspecialchars($viewFile);
             } else {
                echo "Une erreur est survenue lors du chargement de la page.";
             }
             exit;
        }
        require_once $viewFile;

        $footerPath = BASE_PATH . '/app/Views/layouts/footer.php';
        
    }
}
