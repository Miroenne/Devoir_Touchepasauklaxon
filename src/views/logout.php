<?php
session_start();
require __DIR__ . '/../../autoloader.php';

use App\Exception\Serialized;

use App\User\UserRepository;
use App\User\UserServices;
use App\User\UserControllers;

$userController = new UserControllers(new UserServices(new UserRepository), new Serialized());

$id = (int) $_POST['id'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon - logout error</title>
</head>

<body>
    <main>
        <div>
            <?php
            if ($id === $_SESSION['id']) {

                $logout = $userController->logoutController($id);

                if ($logout) { ?>
                    <h1>Déconnexion réussie !</h1>


                <?php }
            } else { ?>
                <h1>Une erreur s'est produite lors de la déconnexion !</h1>
            <?php } ?>
        </div>
        <div>
            <form method="GET">
                <input type="submit" value="Retour Accueil" />
            </form>
        </div>
    </main>
</body>

</html>