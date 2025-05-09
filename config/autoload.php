<?php
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../classes/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
?>