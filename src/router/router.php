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


        switch (true) {
            case str_contains($action, 'getAll'):

                $controller = $class::create();
                $controller->$action();
                break;
            case str_contains($action, 'ById'):
            case str_contains($action, 'logoutCont'):

                $id = $_POST['id'];

                $controller = $class::create();
                $controller->$action($id);
                break;
            case str_contains($action, 'ByEmail'):


                $email = $_POST['email'];

                $controller = $class::create();
                $controller->$action($email);
                break;
            case str_contains($action, 'login'):


                $email = $_POST['email'];
                $password = $_POST['password'];

                $controller = $class::create();
                $controller->$action($email, $password);
                break;
            default:
                $controller = new $class();
                $controller->$action();
                break;
        }


        exit;
    }
}

http_response_code(404);
echo 'Route introuvable';
