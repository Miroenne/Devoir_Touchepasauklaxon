<?php

spl_autoload_register(function ($class) {

    $class = str_replace('App\\', '', $class);

    $map = [
        'Database\\ConnectDatabase' => 'db/connect.php',
        'Exception\\InvalidCredentialsException' => 'utils/invalidcredentials.php',
        'Exception\\DomainException' => 'utils/domainexception.php',
        'Exception\\Serialized' => 'utils/exceptionserialize.php',
        'Views\\ViewsController' => 'controllers/ViewsController.php',
        'User\\UserModel' => 'models/User.php',
        'User\\UserRepository' => 'repositories/userRepository.php',
        'User\\UserServices' => 'services/userServices.php',
        'User\\UserControllers' => 'controllers/userControllers.php',
        'Trip\\TripModel' => 'models/Trips.php',
        'Agency\\AgencyModel' => 'models/Agencies.php',
        'Agency\\AgencyRepository' => 'repositories/agencyRepository.php'

    ];


    if (isset($map[$class])) {
        $path = __DIR__ . '/src/' . $map[$class];
        require $path;
    }
});
