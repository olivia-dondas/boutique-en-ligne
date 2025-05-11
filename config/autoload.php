<?php
spl_autoload_register(function ($class) {
    // Convertit les namespaces en chemin de fichier
    $class = str_replace('\\', '/', $class);
    
    $paths = [
        __DIR__ . '/../classes/',
        __DIR__ . '/../models/',  // Ajouté pour les modèles comme Product
        __DIR__ . '/../controllers/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    
    // Debug utile en développement
    if (getenv('APP_ENV') === 'development') {
        error_log("Autoloader: Class $class not found in paths: " . implode(', ', $paths));
    }
});