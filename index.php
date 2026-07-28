<?php
session_start();
require __DIR__ . '/autoloader.php';

use App\Database\ConnectDatabase;
use App\Exception\Serialized;
use App\User\UserModel;
use App\User\UserRepository;
use App\User\UserServices;
use App\User\UserController;

use App\Trip\TripModel;

use App\Agency\AgencyModel;

/**
 * CODES DE TEST A SUPPRIMER AVANT MISE EN PROD
 */

  $userController = new UserController(new UserServices(new UserRepository), new Serialized());

  $result = $userController->login();

  echo '<prev>';
  var_dump($result);
  echo '<br>';
  echo $result['message'];
  echo '<br>';
  echo $result['code'];


  /*
  $user = json_decode($result['user']);  
  $respCode = $result['responseCode'];
  echo '<pre>';
  echo $respCode;
  echo '<pre>';
  echo $user->id;
  */

  

/*
$userService = new UserServices(new UserRepository());

$user = $userService->login('alexandre.martin@email.fr', 'Martin@AlexandreMDP');
echo 'Variable user depuis index.php : <br>';
var_dump($user);*/


  /*if($_SESSION['isConnected']){
    echo 'utilisateur connecté : ';
  }
    echo '<pre>';
    echo $user->getLastName();
    echo '<pre>';
    echo $user->getFirstName();
*/

 /*foreach($users as $user){
   echo '<pre>';
    var_dump($user);
    echo '<pre>';
    
    echo $user->getLastName();
    echo '<pre>';
    echo $user->getFirstName();
    echo '<pre>';
    echo $user->getEmail();
    echo '<pre>';
    echo $user->getPhoneNumber();
    echo '<pre>';

}*/