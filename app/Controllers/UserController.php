<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        if (!isset($_SESSION['user_id'])) {
            // Utilisation de la constante BASE_URL
            $loginUrl = BASE_URL . 'auth/showLoginForm';
            if (!headers_sent()) {
                header('Location: ' . $loginUrl);
                exit();
            } else {
                error_log("UserController Construct: Headers already sent, cannot redirect to login.");
                if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                    echo "Erreur critique: Redirection impossible (UserController Construct). Les en-têtes ont déjà été envoyés.";
                } else {
                    echo "Une erreur de session est survenue.";
                }
                exit();
            }
        }
    }
    
    public function index() {
        $this->profile();
    }

    public function profile() {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId === null || (int)$userId <= 0) {
            session_unset();
            session_destroy();
            // Utilisation de la constante BASE_URL
            $loginUrl = BASE_URL . 'auth/showLoginForm';
            if (!headers_sent()) {
                header('Location: ' . $loginUrl);
                exit();
            } else {
                error_log("UserController Profile (userId invalid): Headers already sent.");
                 if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                    echo "Erreur critique: Session invalide, redirection impossible (UserController Profile).";
                } else {
                    echo "Une erreur de session est survenue.";
                }
                exit();
            }
        }

        $userData = $this->userModel->getUserById((int)$userId);

        if ($userData === false || $userData === null) {
            session_unset();
            session_destroy();
            // Utilisation de la constante BASE_URL
            $loginUrl = BASE_URL . 'auth/showLoginForm';
            if (!headers_sent()) {
                header('Location: ' . $loginUrl);
                exit();
            } else {
                error_log("UserController Profile (userData invalid): Headers already sent.");
                if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                    echo "Erreur critique: Données utilisateur introuvables, redirection impossible (UserController Profile).";
                } else {
                    echo "Une erreur de session est survenue.";
                }
                exit();
            }
        }
        
        // La méthode renderView passera BASE_URL comme $baseUrl à la vue
        $this->renderView('user/profil', ['user' => $userData]);
    }

    // Helper pour rendre les vues
    // BASE_PATH et BASE_URL sont des constantes maintenant
    protected function renderView(string $viewPath, array $data = []) {
        extract($data);
        // Passer BASE_URL à la vue sous le nom de variable $baseUrl si les vues l'utilisent
        $baseUrl = BASE_URL; 

        if (!file_exists(BASE_PATH . '/app/Views/' . $viewPath . '.php')) {
             error_log("UserController::renderView - Fichier de vue NON TROUVÉ: " . BASE_PATH . '/app/Views/' . $viewPath . '.php');
             if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                echo "Erreur critique: Fichier de vue manquant: " . htmlspecialchars(BASE_PATH . '/app/Views/' . $viewPath . '.php');
             } else {
                echo "Une erreur est survenue lors du chargement de la page.";
             }
             exit;
        }
        require_once BASE_PATH . '/app/Views/' . $viewPath . '.php';
    }
}

