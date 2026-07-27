<?php

namespace App\User;
use App\Error\ErrorBuilder;

class UserServices {

    public function __construct(private UserRepository $repository){}
    

    public function getUserById(int $id) {

        $user = $this->repository->getUserById($id);
        
        if(!$user){
            throw new ErrorBuilder('User not found', 404);
        }

        return $user;

    }

}