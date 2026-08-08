<?php

namespace App\Views;

class ViewsController
{
    public function index(): void
    {
        require __DIR__ . '/../views/dashboard.php';
    }

    public function login(): void
    {
        require __DIR__ . '/../views/login.php';
    }

    public function logout(): void
    {
        require __DIR__ . '/../views/logout.php';
    }
}
