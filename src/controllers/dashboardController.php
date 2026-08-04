<?php

namespace App\Views;

class DashboardController
{
    public function index(): void
    {
        require __DIR__ . '/../views/dashboard.php';
    }
}
