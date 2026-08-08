<?php

namespace App\User;

use App\User\UserModel;
use InvalidArgumentException;
use App\Database\ConnectDatabase;
use PDO;

class UserRepository
{


    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::connect();
    }

    public function mapUserToUserListItem(UserModel $user): ?UserModel
    {

        return new UserModel(
            id: (int)$user->getId(),
            lastName: $user->getLastName(),
            firstName: $user->getFirstName(),
            email: $user->getEmail(),
            phoneNumber: $user->getPhoneNumber(),
            passwordHash: 'null',
            admin: (bool)$user->getAdmin()
        );
    }

    private function mapRowToUserListItem(array $row): ?UserModel
    {

        return new UserModel(
            id: (int)$row['user_Id'],
            lastName: $row['user_LastName'],
            firstName: $row['user_FirstName'],
            email: $row['user_Email'],
            phoneNumber: $row['user_PhoneNumber'],
            passwordHash: 'null',
            admin: (bool)$row['user_Admin']
        );
    }

    private function mapRowToUser(array $row): ?UserModel
    {

        return new UserModel(
            id: (int)$row['user_Id'],
            lastName: $row['user_LastName'],
            firstName: $row['user_FirstName'],
            email: $row['user_Email'],
            phoneNumber: $row['user_PhoneNumber'],
            passwordHash: $row['user_Password'],
            admin: (bool)$row['user_Admin']
        );
    }

    public function getAllUsers(): ?array
    {

        $stmt = $this->pdo->query("SELECT user_Id, user_FirstName, user_LastName, user_Email,
         user_PhoneNumber, user_Admin FROM users ORDER BY user_Admin DESC, user_LastName ASC");

        $rows = $stmt->fetchAll();
        if (!$rows) {
            return null;
        }
        foreach ($rows as $row) {
            $users[] = $this->mapRowToUserListItem($row);
        }

        return $users;
    }

    public function getUserById(?int $id): ?UserModel
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_Id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return $this->mapRowToUser($row);
    }

    public function getUserByEmail(string $email): ?UserModel
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_Email = :email");
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return $this->mapRowToUser($row);
    }
}
