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

$userController = new UserController(new UserServices(new UserRepository), new Serialized());

$token = $_COOKIE['csrf-token'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Touche pas au klaxon</title>
</head>

<body>
  <?php
  if (!$token) {
  ?>
    <main>
      <button type="button" onclick="window.location.href='/src/pages/login.php'">Connexion</button>
    </main>
  <?php
  } else {

    $jsonUser = $userController->getUserByIdController($_SESSION['id']);
    $user = json_decode($jsonUser);
  ?>
    <main>
      <h1>Bonjour, <?php echo $user->firstName . ' ' . $user->lastName ?></h1>
      <button onclick="window.location.href='/src/pages/logout.php'">
        Déconnexion
      </button>
    </main>
  <?php
  }
  ?>
</body>

</html>