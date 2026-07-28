<?php

namespace App\Exception;

class DomainException extends \RuntimeException {

    public function __construct(string $message){
        parent::__construct($message);
    }

}