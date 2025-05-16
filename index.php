<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// /Applications/MAMP/htdocs/testbibine/index.php

// 1. Inclure le fichier de configuration (qui contient l'autoloader)
require_once __DIR__ . '/config.php'; 

// 2. Routage
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$urlParts = explode('/', $url);

$controllerName = !empty($urlParts[0]) ? ucfirst(strtolower($urlParts[0])) . 'Controller' : 'HomeController'; 
$actionName = !empty($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

$controllerClassName = 'App\\Controllers\\' . $controllerName;

// Log avant class_exists pour voir ce qu'on teste
error_log("Router: Tentative de vérification de la classe : " . $controllerClassName);
error_log("Chemin attendu du contrôleur : " . __DIR__ . '/app/Controllers/' . $controllerName . '.php');
error_log("Fichier existe ? " . (file_exists(__DIR__ . '/app/Controllers/' . $controllerName . '.php') ? 'OUI' : 'NON'));

if (class_exists($controllerClassName)) { // L'autoloader de config.php devrait être appelé ici
    error_log("Router: Classe " . $controllerClassName . " TROUVÉE par class_exists.");
    try {
        $controllerInstance = new $controllerClassName();
        if (method_exists($controllerInstance, $actionName)) {
            call_user_func_array([$controllerInstance, $actionName], $params);
        } else {
            http_response_code(404);
            error_log("Router: Action non trouvée - {$actionName} dans {$controllerClassName}");
            if (ENVIRONMENT === 'development') {
                echo "<h1>Erreur 404 : Action non trouvée</h1><p>L'action '{$actionName}' du contrôleur '{$controllerName}' n'existe pas.</p>";
            } else {
                echo "<h1>Page Introuvable</h1>";
            }
        }
    } catch (Throwable $e) {
        error_log("Router: Erreur d'exécution du contrôleur - " . $e->getMessage() . "\n" . $e->getTraceAsString());
        http_response_code(500);
        // ... affichage de l'erreur ...
    }
} else {
    http_response_code(404);
    // Ce log est celui que vous voyiez avant
    error_log("Router: Contrôleur non trouvé (après class_exists a échoué) - " . $controllerClassName . " (BASE_PATH: " . BASE_PATH . ")");
    if (ENVIRONMENT === 'development') {
        echo "<h1>Erreur 404 : Contrôleur non trouvé</h1><p>Le contrôleur '{$controllerName}' (classe '{$controllerClassName}') n'existe pas. Vérifiez le chemin et le namespace.</p>";
    } else {
        echo "<h1>Page Introuvable</h1>";
    }
}

if ($url === 'auth/login') {
    (new \App\Controllers\AuthController())->showLoginForm();
    exit;
}
if ($url === 'auth/register') {
    (new \App\Controllers\AuthController())->showRegisterForm();
    exit;
}
?>
