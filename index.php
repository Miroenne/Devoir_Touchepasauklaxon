<?php

require __DIR__ . '/autoloader.php';

use App\Database\ConnectDatabase;

use App\User\UserModel;
use App\User\UserRepository;
use App\User\UserServices;

use App\Trip\TripModel;

use App\Agency\AgencyModel;

$userRepo = new UserRepository();

$users = $userRepo->getAllUsers();

foreach($users as $user){
    /*echo '<pre>';
    var_dump($user);*/
    echo '<pre>';
    
    echo $user->getLastName();
    echo '<pre>';
    echo $user->getFirstName();
    echo '<pre>';
    echo $user->getEmail();
    echo '<pre>';
    echo $user->getPhoneNumber();
    echo '<pre>';

}