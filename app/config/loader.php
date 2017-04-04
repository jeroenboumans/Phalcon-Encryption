<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(

    // Application dirs
    'YourApplication\Models' => $config->application->modelsDir . 'YourApplication/',
    'YourApplication\Classes' => $config->application->classesDir,

    // Security
    'Security\Classes'  => $config->application->security->classesDir,
    'Security\Models'   => $config->application->security->modelsDir
    
));



$loader->register();

// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
