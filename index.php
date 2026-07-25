<?php

require __DIR__ . '/autoloader.php';

use App\UserModel\User;

$model = new User();
$user = json_decode($model->getUser(), true);

echo $user['nom'];
echo $user['prenom'];
echo $user['email'];