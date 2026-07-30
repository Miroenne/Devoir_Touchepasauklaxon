<?php

namespace App\User;

use App\User\UserServices;
use App\Exception\InvalidCredentialsException;
use App\Exception\DomainException;
use App\Exception\Serialized;

use JsonSerializable;


class UserController {

    public function __construct(private UserServices $services, private Serialized $serialize){}

    public function login() {
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        try{
            $result = $this->services->login($email, $password);
            
             setcookie(
                'csrf-token',
                $result['csrfToken'],
                [
                    'expires' => time() + 60 * 60 * 24,
                    'path' => '/',
                    'httponly' => true,
                    'secure' => true,
                    'samesite' => 'none'
                ]
            );

            $user = $result['user'];

            $json = json_encode($user);
            
            return ['user' => $json, 'responseCode' => 200];


        }catch (InvalidCredentialsException $e){
            return $this->serialize->serializeException($e->getMessage(), 401);
        }catch(DomainException $e){
            return $this->serialize->serializeException($e->getMessage(), 404);
        }        
        
    }

    public function getAllUsers() {

        try{
            $result = $this->services->getAllUsers();

            $users = $result;
            

            foreach($users as $user){
               
                $json = json_encode($user);
                $jsonUsers [] = $json;

            }

            return $jsonUsers;
        }catch(DomainException $e){
            return $this->serialize->serializeException($e->getMessage(), 401);
        }

    }

}