<?php
session_start();

require dirname(__DIR__) . '/controllers/userControllers.php';

use App\Exception\Serialized;

use App\User\UserRepository;
use App\User\UserServices;
use App\User\UserControllers;

use App\Trip\TripModel;

use App\Agency\AgencyModel;

$userController = new UserControllers(new UserServices(new UserRepository), new Serialized());

$token = $_COOKIE['csrf-token'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logout = $userController->logoutController($_POST['id']);

    if ($logout) {
        header('Location: ../../index.php');
        exit;
    }
}

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
            <button type="button" onclick="window.location.href='/src/views/login.php'">Connexion</button>
        </main>
    <?php
    } else {

        $jsonUser = $userController->getUserByIdController($_SESSION['id']);
        $user = json_decode($jsonUser);
    ?>
        <main>
            <h1>Bonjour, <?php echo $user->firstName . ' ' . $user->lastName ?></h1>
            <form method="post">
                <input hidden=true name='id' value=<?php $_SESSION['id'] ?>>
                <input type="submit" value="Déconnexion">
            </form>
        </main>
    <?php
    }
    ?>
</body>

</html>