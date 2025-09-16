<?php
ob_start();

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/config/db.php';
require_once BASE_PATH . '/core/autoload.php';
require_once BASE_PATH . '/core/helper.php';
require_once BASE_PATH . '/core/Router.php';
$router = new Router();
require_once BASE_PATH . '/config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($uri, $method);
} catch (Throwable $e) {
    http_response_code(500);
    echo "Internal Server Error";
}

ob_end_flush();
