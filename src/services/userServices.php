<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\UserModel;
use App\Utils\InvalidCredentialsException;
use InvalidArgumentException;
use App\Utils\DomainException;



class UserServices
{

    private const DUMMY_HASH = '$2y$12$16BE.wBO2SntbWp43y3yxOvl6Sbk7tMurZDqFC8iFwPjd6tAWlVGm';

    public function __construct(private UserRepository $repository) {}

    public function loginService(string $email, string $plainPassword)
    {
        $user = $this->repository->getUserByEmail($email);

        if ($user === null) {

            password_verify($plainPassword, self::DUMMY_HASH);
            throw new InvalidCredentialsException('Connection failed, invalid credentials');
        }

        if (!password_verify($plainPassword, $user->getPasswordHash())) {
            throw new InvalidCredentialsException('Connection failed, invalid credentials');
        }

        $csrfToken = bin2hex(random_bytes(32));

        $user = $this->repository->mapUserToUserListItem($user);

        return ['user' => $user, 'csrfToken' => $csrfToken];
    }


    public function getAllUsersService(): ?array
    {
        $users = $this->repository->getAllUsers();

        if ($users === null) {
            throw new DomainException('No user found');
        }

        return $users;
    }

    public function getUserByIdService(int $id): ?UserModel
    {

        $user = $this->repository->getUserById($id);

        if ($user === null) {
            throw new DomainException('User not found');
        }

        return $user;
    }

    public function getUserByEmailService(string $email): ?UserModel
    {
        $user = $this->repository->getUserByEmail($email);

        if ($user === null) {
            throw new DomainException('User not found');
        }

        return $user;
    }
}
