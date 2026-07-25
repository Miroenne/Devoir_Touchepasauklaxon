<?php

namespace App\UserModel;

class User{

    private $user = [
        'nom' => 'Doe',
        'prenom' => 'John',
        'email' => 'jdoe@xxx.com'
    ];

    function getUser() {
        $json = json_encode($this->user);
        return $json;
    }

}