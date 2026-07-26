<?php

spl_autoload_register(function ($class){

    $class = str_replace('App\\', '', $class);   
    
    $map = [
        'User\\UserModel' => 'models/User.php',
        'Trip\\TripModel' => 'models/Trips.php',
        'Agency\\AgencyModel' => 'models/Agencies.php'
    ];


    if(isset($map[$class])){        
        $path = __DIR__ . '/src/' . $map[$class];
        require $path;
    }
});