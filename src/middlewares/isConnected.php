<?php

namespace App\Middlewares;

class IsConnected
{

    public function __construct()
    {
        if (!$_SESSION['id']) {
            return false;
        }
        return true;
    }
}
