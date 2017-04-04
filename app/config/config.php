<?php
return new \Phalcon\Config(array(

    'database' => array(

        // default MAMP credentials
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'default'
    ),

    'databaseSecurity' => array(

        // default MAMP credentials
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'security'
    ),

    'application' => array(
        // ...
        'modelsDir' => APP_DIR . '/models/',
        'classesDir' => APP_DIR . '/classes/',
        'security' => [
            'classesDir' => APP_DIR . '/classes/security/',
            'modelsDir' => APP_DIR . '/models/Security/'
        ]
    ),

    // ...
));
