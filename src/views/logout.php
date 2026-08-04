<?php
session_start();
require __DIR__ . '/../../autoloader.php';

use App\Exception\Serialized;
use App\User\UserController;
use App\User\UserRepository;
use App\User\UserServices;

$serialize = new Serialized();
$userController = new UserController(new UserServices(new UserRepository()), new Serialized());

$logout = $userController->logoutController($_SESSION['id']);
if ($logout === true) {
    header('Location: ../../index.php');
    exit;
} else { ?>

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
                <h1><?php echo $logout['code'] . ' - ' . $logout['message'] ?></h1>
            </div>
            <div>
                <button onclick="window.location.href = '/../../index.php'">Retour</button>
            </div>
        </main>
    </body>

    </html>

<?php } ?>