<?php

namespace App\Exception;

class Serialized{

    public function __contruct(){
        
    }


    public function serializeException(string $message, int $code): array{
        return [
            'message' => $message,
            'code' => $code
        ];
    }

}