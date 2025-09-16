<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);

    $baseDirs = [
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/',
        BASE_PATH . '/core/',
    ];

    foreach ($baseDirs as $dir) {
        $file = $dir . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }

    trigger_error("Autoloader: Class {$class} tidak ditemukan.", E_USER_WARNING);
});
