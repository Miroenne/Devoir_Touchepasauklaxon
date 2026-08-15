<?php

namespace App\Controllers;

use App\Services\UserServices;
use App\Repositories\UserRepository;
use App\Utils\InvalidCredentialsException;
use App\Utils\DomainException;
use App\Utils\ExceptionSerialize;

use JsonSerializable;


class UserControllers
{

    public function __construct(private UserServices $services, private ExceptionSerialize $serialize) {}

    public static function create(): self
    {
        return new self(new UserServices(new UserRepository()), new ExceptionSerialize());
    }


    public function loginController(string $email, string $password)
    {

        try {
            $result = $this->services->loginService($email, $password);

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
        } catch (InvalidCredentialsException $e) {
            return $this->serialize->serializeException($e->getMessage(), 401);
        } catch (DomainException $e) {
            return $this->serialize->serializeException($e->getMessage(), 404);
        }
    }

    public function logoutController(int $id)
    {

        if ($_SESSION['id'] === $id) {
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(session_name(), '', [
                    'expires' => time() - 42000,
                    'path' => $p['path'],
                    'domain' => $p['domain'],
                    'secure' => $p['secure'],
                    'httponly' => $p['httponly'],
                    'samesite' => $p['samesite'],
                ]);
            }

            setcookie('csrf-token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => 'true',
                'secure' => true,
                'samesite' => 'none'
            ]);


            session_destroy();
            return true;
        } else {
            $error = [
                'message' => "Une erreur s'est produite, déconnexion impossible",
                'code' => 401
            ];
            return $error;
        }
    }

    public function getAllUsersController()
    {
        // if ($_SESSION) {

        try {
            $result = $this->services->getAllUsersService();

            $users = $result;


            foreach ($users as $user) {

                $json = json_encode($user);

                $jsonUsers[] = $json;
            }
            var_dump($jsonUsers);
            return $jsonUsers;
        } catch (DomainException $e) {
            return $this->serialize->serializeException($e->getMessage(), 404);
        }
        /*  } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }*/
    }

    public function getUserByIdController(int $id)
    {

        if ($_SESSION['id'] === $id || $_SESSION['admin'] === true) {
            try {
                $result = $this->services->getUserByIdService($id);
                $user = json_encode($result);

                return $user;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }
    }

    public function getUserByEmailController(int $id, string $email)
    {

        if ($_SESSION['id'] === $id || $_SESSION['admin'] === true) {
            try {
                $result = $this->services->getUserByEmailService($email);
                $user = json_encode($result);
                echo $user;
                return $user;
            } catch (DomainException $e) {
                return $this->serialize->serializeException($e->getMessage(), 404);
            }
        } else {
            return $error = [
                'message' => 'Credentials required',
                'responseCode' => 403
            ];
        }
    }
}
