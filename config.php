<?php
// config.php

// 1. Configuration de l'environnement et des erreurs
define('ENVIRONMENT', 'development'); // 'production' sur serveur live

if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    if (!is_dir(__DIR__ . '/logs')) { // __DIR__ ici est testbibine/
        mkdir(__DIR__ . '/logs', 0755, true);
    }
    ini_set('error_log', __DIR__ . '/logs/php_errors.log'); 
}

// 2. Constante BASE_PATH (racine du projet)
define('BASE_PATH', __DIR__); // __DIR__ ici est /Applications/MAMP/htdocs/testbibine

// 3. Configuration de l'URL de Base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
// SCRIPT_NAME si index.php (routeur) est à la racine de testbibine/ sera /testbibine/index.php
// dirname($_SERVER['SCRIPT_NAME']) sera /testbibine
$scriptPath = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($scriptPath === '/' || $scriptPath === '\\' || $scriptPath === '.') {
    $baseDirectory = '/'; 
} else {
    $baseDirectory = rtrim($scriptPath, '/') . '/'; // Devrait être /testbibine/
}
define('BASE_URL', $protocol . $host . $baseDirectory);

// 4. Gestion robuste des sessions
if (session_status() === PHP_SESSION_NONE) {
    $isSecure = (ENVIRONMENT === 'production' && $protocol === 'https://');
    session_set_cookie_params([
        'lifetime' => 86400, 
        'path' => $baseDirectory, 
        'domain' => $host,
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// 5. Constantes de l'Application
define('SITE_NAME', 'Bibine - Votre Cave d\'Exception');

// 6. Autoloader (pour les classes dans app/)
spl_autoload_register(function ($class_name) {

    $file = BASE_PATH . '/' . str_replace('\\', '/', lcfirst($class_name)) . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Autoloader (config.php): Classe non trouvée - " . $class_name . " (tentative: " . $file . ")");
    }
});


?>
