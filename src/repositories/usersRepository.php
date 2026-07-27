<?php

namespace App\User;

use App\User\UserModel;
use InvalidArgumentException;
use App\Database\ConnectDatabase;
use PDO;

class UserRepository{

    
    private PDO $pdo;

    public function __construct(){
        $this->pdo = ConnectDatabase::connect();
    }

    
    private function mapRowToUser(array $row): UserModel {
        return new UserModel(
            id: (int)$row['user_Id'],
            lastName: $row['user_LastName'],
            firstName: $row['user_FirstName'],
            email: $row['user_Email'],
            phoneNumber: $row['user_PhoneNumber'],
            passwordHash: $row['user_Password'] ?? null,
            admin: (int)$row['user_Admin'] ?? null
        );
    } 

    public function getUserById(?int $id): UserModel{
        $stmt = $this->pdo-> prepare("SELECT * FROM users WHERE user_Id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        $user = $this->mapRowToUser($row);

        if(!$user){
            throw new InvalidArgumentException('No user found');
        }else{
            return $user;
        }
    }

}