<?php

spl_autoload_register(function ($class){

    $class = str_replace('App\\', '', $class);   
    
    $map = [
        'UserModel\\User' => 'models/User.php',
    ];


    if(isset($map[$class])){        
        $path = __DIR__ . '/src/' . $map[$class];
        require $path;
    }
});