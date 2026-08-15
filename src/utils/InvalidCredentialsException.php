<?php

namespace App\Utils;

class InvalidCredentialsException extends \RuntimeException {

    public function __construct(string $message){
        parent::__construct($message);
    }


}