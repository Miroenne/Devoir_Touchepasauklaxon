<?php
session_start();

require dirname(__DIR__) . '/controllers/userControllers.php';

use App\Exception\Serialized;

use App\User\UserRepository;
use App\User\UserServices;
use App\User\UserControllers;
use App\Agency\AgencyRepository;
use App\Agency\AgencyServices;


$userController = new UserControllers(new UserServices(new UserRepository), new Serialized());

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
            <button type="button" onclick="window.location.href='/src/views/login.php'">Connexion</button>
        </main>
    <?php
    } else {

        $jsonUser = $userController->getUserByIdController($_SESSION['id']);
        $user = json_decode($jsonUser);
        $id = $user->id;
    ?>
        <main>
            <h1>Bonjour, <?php echo $user->firstName . ' ' . $user->lastName ?></h1>
            <form method="post">
                <input type='number' hidden=true id="id" name='id' value="<?php echo $id ?>" />
                <input type="submit" value="Déconnexion" />
            </form>
            <?php
            if ($_SESSION['admin'] === true) { ?>
                <form action="/agencies" method="GET">
                    <input type="submit" value="Agences" />
                </form>
            <?php } ?>
        </main>
    <?php
    }


    ?>
</body>

</html>