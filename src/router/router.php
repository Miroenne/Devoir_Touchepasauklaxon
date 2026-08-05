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

        echo 'dans le routeur ';
        echo $action;

        /*
        if (str_contains('index', $route['action'])) {

            echo 'Index route';

            $controller = new $class();
            $controller->$action();
        } elseif (str_contains('getUser', $route['action'])) {

            echo 'getuser or logout route';

            $argument = $route['argument'];

            $controller = $class::create();
            $controller->$action($argument);
        } elseif (str_contains('login', $route['action'])) {

            echo 'login route';

            $email = $route['email'];
            $password = $route['password'];

            $controller = $class::create();
            $controller->$action($email, $password);
        } else {
            $controller = $class::create();
            $controller->$action();
        }*/

        switch (true) {
            case str_contains($action, 'getAll'):
                echo 'GetAll route';
                $controller = $class::create();
                $controller->$action();
                break;
            case str_contains($action, 'ById'):
            case str_contains($action, 'logout'):
                echo 'getbyid or logout route';

                $id = $_POST['id'];

                $controller = $class::create();
                $controller->$action($id);
                break;
            case str_contains($action, 'ByEmail'):
                echo 'getbyemail route';

                $email = $_POST['email'];

                $controller = $class::create();
                $controller->$action($email);
                break;
            case str_contains($action, 'login'):
                echo 'login route';

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
