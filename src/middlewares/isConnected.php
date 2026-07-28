<?php

namespace App\Middlewares;

class IsConnected{

    public function __construct() {
        if($_SESSION === false){
            return false;
        }
        return true;
    }

}