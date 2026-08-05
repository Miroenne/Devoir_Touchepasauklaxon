<?php

return [
    [
        'method' => 'GET',
        'path' => '/',
        'namespace' => 'App\\Views\\',
        'controller' => 'DashboardController',
        'action' => 'index'
    ],
    [
        'method' => 'POST',
        'path' => '/user/login',
        'namespace' => 'App\\User\\',
        'controller' => 'userControllers',
        'action' => 'loginController',
    ],
    [
        'method' => 'POST',
        'path' => '/user/logout',
        'namespace' => 'App\\User\\',
        'controller' => 'userControllers',
        'action' => 'logoutController',

    ],
    [
        'method' => 'GET',
        'path' => '/user',
        'namespace' => 'App\\User\\',
        'controller' => 'userControllers',
        'action' => 'getAllUsersController'
    ],
    [
        'method' => 'POST',
        'path' => '/user/id',
        'namespace' => 'App\\User\\',
        'controller' => 'userControllers',
        'action' => 'getUserByIdController',

    ],
    [
        'method' => 'POST',
        'path' => '/user/email',
        'namespace' => 'App\\User\\',
        'controller' => 'userControllers',
        'action' => 'getUserByEmailController',

    ],
];
