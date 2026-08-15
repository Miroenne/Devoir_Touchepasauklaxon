<?php

namespace App\Controllers;

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

    public function agencies(): void
    {
        require __DIR__ . '/../views/agencies.php';
    }

    public function trip(): void
    {
        require __DIR__ . '/../views/trip.php';
    }

    public function test()
    {
        require __DIR__ . '/../views/test.php';
    }
}
