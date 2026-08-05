<?php


$routes = require __DIR__ . '/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

foreach ($routes as $route) {

    if ($route['method'] === $method && $route['path'] === $path) {

        $file = dirname(__DIR__, 2) . "/src/controllers/{$route['controller']}.php";

        require_once $file;
        $class = $route['namespace'] . $route['controller'];
        $action = $route['action'];

        if (str_contains('index', $route['action'])) {

            $controller = new $class();
            $controller->$action();
        } else {
            $controller = $class::create();
            $controller->$action();
        }

        exit;
    }
}

http_response_code(404);
echo 'Route introuvable';
