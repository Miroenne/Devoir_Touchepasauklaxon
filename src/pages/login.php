<?php
session_start();
require __DIR__ . '/../../autoloader.php';

use App\Exception\Serialized;
use App\User\UserController;
use App\User\UserRepository;
use App\User\UserServices;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userController = new UserController(new UserServices(new UserRepository()), new Serialized());

    $email = $_POST['email'];
    $password = $_POST['mdp'];

    $login = $userController->loginController($email, $password);

    $user = json_decode($login['user']);
    $_SESSION['id'] = $user->id;
    $_SESSION['admin'] = $user->admin;
    header('Location: ../../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon - Connexion</title>
</head>

<body>
    <header></header>
    <main>
        <form method='POST'>
            <fieldset>
                <legend>Saississez votre email et votre mot de passe</legend>
                <br><label for="email">Email</label><br>
                <input type="text" id="email" name="email" required><br>

                <label for="mdp">Mot de passe</label><br>
                <input type="password" id="mdp" name="mdp" required><br><br>

                <input type="submit" value="Soumettre">
            </fieldset>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>