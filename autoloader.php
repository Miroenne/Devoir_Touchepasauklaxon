<?php

spl_autoload_register(function ($class){

    $class = str_replace('App\\', '', $class);   
    
    $map = [
        'Database\\ConnectDatabase' => 'db/connect.php',
        'User\\UserModel' => 'models/User.php',
        'User\\UserRepository' => 'repositories/usersRepository.php',
        'User\\UserServices' => 'services/usersServices.php',
        'Trip\\TripModel' => 'models/Trips.php',
        'Agency\\AgencyModel' => 'models/Agencies.php',
        
    ];


    if(isset($map[$class])){        
        $path = __DIR__ . '/src/' . $map[$class];
        require $path;
    }
});