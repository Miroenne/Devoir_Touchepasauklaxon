<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\ViewsController', 'index']);
    $r->addRoute('POST', '/', ['App\Controllers\ViewsController', 'logout']);
    $r->addRoute('GET', '/agencies', ['App\Controllers\ViewsController', 'agencies']);
    $r->addRoute('GET', '/trip', ['App\Controllers\ViewsController', 'trip']);
    $r->addRoute('GET', '/test', ['App\Controllers\ViewsController', 'test']);
    $r->addRoute('GET', '/login', ['App\Controllers\ViewsController', 'login']);

    $r->addRoute('POST', '/user/login', ['App\Controllers\UserControllers', 'loginController']);
    $r->addRoute('POST', '/user/logout', ['App\Controllers\UserControllers', 'logoutController']);
    $r->addRoute('GET', '/user', ['App\Controllers\UserControllers', 'getAllUsersController']);
    $r->addRoute('POST', '/user/id', ['App\Controllers\UserControllers', 'getUserByIdController']);
    $r->addRoute('POST', '/user/email', ['App\Controllers\UserControllers', 'getUserByEmailController']);

    $r->addRoute('POST', '/agency/all', ['App\Controllers\AgencyControllers', 'getAllAgenciesController']);
};
