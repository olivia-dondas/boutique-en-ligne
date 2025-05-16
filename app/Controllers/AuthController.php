<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $this->showLoginForm();
    }

    public function showLoginForm() {
        if (isset($_SESSION['user_id'])) {
            // Utilisation de la constante BASE_URL
            header('Location: ' . BASE_URL . 'user/profile');
            exit();
        }
        // La méthode renderView passera BASE_URL comme $baseUrl à la vue
        $this->renderView('auth/login');
    }

    public function showRegisterForm() {
        if (isset($_SESSION['user_id'])) {
            // Utilisation de la constante BASE_URL
            header('Location: ' . BASE_URL . 'user/profile');
            exit();
        }
        $this->renderView('auth/register');
    }

    public function processRegister() {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => 'Une erreur inattendue est survenue.'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response['message'] = 'Méthode non autorisée.';
            echo json_encode($response);
            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
             $response['message'] = 'Données JSON invalides: ' . json_last_error_msg();
             echo json_encode($response);
             exit();
        }

        $firstName = trim($input['first_name'] ?? '');
        $lastName = trim($input['last_name'] ?? '');
        $email = trim($input['email'] ?? '');
        $birthDate = trim($input['birth_date'] ?? '');
        $password = $input['password'] ?? '';
        $passwordConfirm = $input['password_confirm'] ?? '';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($birthDate) || empty($password) || empty($passwordConfirm)) {
            $response['message'] = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = "Format d'email invalide.";
        } elseif ($password !== $passwordConfirm) {
            $response['message'] = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($password) < 6) {
            $response['message'] = "Le mot de passe doit faire au moins 6 caractères.";
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthDate) || !strtotime($birthDate)) {
            $response['message'] = "Format de date de naissance invalide (YYYY-MM-DD attendu).";
        } elseif ($this->userModel->findByEmail($email)) {
            $response['message'] = "Cet email est déjà utilisé.";
        } else {
            if ($this->userModel->createUser($firstName, $lastName, $email, $birthDate, $password)) {
                $response['success'] = true;
                $response['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $response['message'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
        echo json_encode($response);
    }

    public function processLogin() {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => 'Une erreur inattendue est survenue.'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response['message'] = 'Méthode non autorisée.';
            echo json_encode($response);
            exit();
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
         if ($input === null && json_last_error() !== JSON_ERROR_NONE) {
             $response['message'] = 'Données JSON invalides: ' . json_last_error_msg();
             echo json_encode($response);
             exit();
        }
        $email = trim($input['email'] ?? '');
        $passwordSubmitted = $input['password'] ?? '';

        if (empty($email) || empty($passwordSubmitted)) {
            $response['message'] = "L'email et le mot de passe sont requis.";
        } else {
            $user = $this->userModel->findByEmail($email);
            if ($user && password_verify($passwordSubmitted, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_role'] = $user['role'];
                
                $response['success'] = true;
                $response['message'] = "Connexion réussie ! Redirection en cours...";
                // Utilisation de la constante BASE_URL
                $response['redirectUrl'] = BASE_URL . 'user/profile';
            } else {
                $response['message'] = "Email ou mot de passe incorrect.";
            }
        }
        echo json_encode($response);
    }

    public function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        // Utilisation de la constante BASE_URL
        header('Location: ' . BASE_URL . 'auth/showLoginForm');
        exit();
    }

    public function login() {
        $baseUrl = BASE_URL;
        require BASE_PATH . '/app/Views/auth/login.php';
    }

    public function register() {
        $this->showRegisterForm();
    }

    // Helper pour rendre les vues
    // BASE_PATH et BASE_URL sont des constantes maintenant
    protected function renderView(string $viewPath, array $data = []) {
        extract($data);
        // Passer BASE_URL à la vue sous le nom de variable $baseUrl si les vues l'utilisent
        $baseUrl = BASE_URL; 
        
        if (!file_exists(BASE_PATH . '/app/Views/' . $viewPath . '.php')) {
             error_log("AuthController::renderView - Fichier de vue NON TROUVÉ: " . BASE_PATH . '/app/Views/' . $viewPath . '.php');
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
