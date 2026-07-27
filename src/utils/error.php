<?php

namespace App\Error;

class ErrorBuilder extends \Exception {

    public function __construct(string $message, int $code){
        parent::__construct($message, $code);
    }


}