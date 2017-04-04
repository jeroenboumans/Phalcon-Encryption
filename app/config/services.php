<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use \Phalcon\Mvc\Dispatcher as PhDispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Model\Manager as ModelsManager;

$di = new FactoryDefault();
$di->set('config', $config);

// ... Add the db-security to your application's config

$di->set('db-security', function () use ($config) {
    
    // Database connection //    
    $dbAdapter = new DbAdapter(array(
        'host' => $config->databaseSecurity->host,
        'username' => $config->databaseSecurity->username,
        'password' => $config->databaseSecurity->password,
        'dbname' => $config->databaseSecurity->dbname
    ));
    
    return $dbAdapter;
});

// ...