<?php


use FastRoute\Dispatcher;

$dispatcher = FastRoute\simpleDispatcher(require __DIR__ . '/routes.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Route introuvable';
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo 'Méthode non autorisée';
        break;

    case Dispatcher::FOUND:
        [$class, $action] = $routeInfo[1];

        $controller = method_exists($class, 'create') ? $class::create() : new $class();

        switch (true) {
            case str_contains($action, 'getAll'):
                $controller->$action();
                break;

            case str_contains($action, 'ById'):
            case str_contains($action, 'logoutCont'):
                $controller->$action($_POST['id']);
                break;

            case str_contains($action, 'ByEmail'):
                $controller->$action($_POST['id'], $_POST['email']);
                break;

            case str_contains($action, 'loginController'):
                $controller->$action($_POST['email'], $_POST['mdp']);
                break;

            default:
                $controller->$action();
                break;
        }
        break;
}
