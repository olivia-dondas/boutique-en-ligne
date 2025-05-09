<?php
// 1. Sécurité et configuration de base
error_reporting(E_ALL);
ini_set('display_errors', 0); // Désactiver en production
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../logs/php_errors.log');

// 2. Gestion robuste des sessions
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400, // 24h
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => true,    // HTTPS seulement
        'httponly' => true,  // Protection XSS
        'samesite' => 'Strict'
    ]);
    session_start();
}

// 3. Configuration de la base de données (approche professionnelle)
final class DatabaseConfig
{
    private static $instance = null;
    public $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=olivia-dondas_bibine;charset=utf8mb4",
                "root",
                "root",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Database error: ".$e->getMessage());
            http_response_code(500);
            die("Maintenance en cours. Merci de réessayer plus tard.");
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

// 4. Configuration du site
define('SITE_NAME', 'Bibine - Caviste en ligne');
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/boutique-en-ligne/public');
define('ENVIRONMENT', 'development'); // 'production' en live

// 5. Autoloader personnalisé (exemple)
spl_autoload_register(function ($class) {
    $file = __DIR__.'/../src/'.str_replace('\\', '/', $class).'.php';
    if (file_exists($file)) {
        require $file;
    }
});