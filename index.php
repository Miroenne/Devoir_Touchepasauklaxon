<?php

require __DIR__ . '/autoloader.php';

use App\Database\ConnectDatabase;

use App\User\UserModel;
use App\User\UserRepository;

use App\Trip\TripModel;

use App\Agency\AgencyModel;

$userRepo = new UserRepository();

$user = $userRepo->getUserById(2);


echo $user->getFirstName() . '<br>';
echo $user->getLastName() . '<br>';