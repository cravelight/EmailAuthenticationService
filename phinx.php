<?php

// -----------------------------------------------------------------------------
// Standardize the environment
// -----------------------------------------------------------------------------
$siteRoot = dirname(__FILE__) . '/';
date_default_timezone_set('UTC');
require_once $siteRoot . 'vendor/autoload.php';


// Load environment variables (https://github.com/vlucas/phpdotenv)
$dotenv = new Dotenv\Dotenv($siteRoot);
$dotenv->load();

//todo: support sql server
$dotenv->required('DB_ADAPTER')->notEmpty()->allowedValues(['sqlite', 'mysql']); // , 'sqlsrv']);
switch (getenv('DB_ADAPTER')) {
    case 'sqlite':
        $dotenv->required('DB_NAME')->notEmpty();
        break;

    case 'mysql':
        $dotenv->required('DB_HOST')->notEmpty();
        $dotenv->required('DB_NAME')->notEmpty();
        $dotenv->required('DB_USER')->notEmpty();
        $dotenv->required('DB_PASS')->notEmpty();
        $dotenv->required('DB_PORT')->notEmpty()->isInteger();
        $dotenv->required('DB_CHARSET')->notEmpty();
        $dotenv->required('DB_COLLATION')->notEmpty();
        break;
}


// http://docs.phinx.org/en/latest/configuration.html
// - It must return an array of configuration items.
// - The variable scope is local, i.e. you would need to explicitly declare any global variables your initialization file reads or modifies.
// - Its standard output is suppressed.
return array(
    'paths' => array(
        'migrations' => $siteRoot . 'tests/sql/migrations',
        'seeds' => $siteRoot . 'tests/sql/seeds'
    ),
    'environments' => array(
        'default_migration_table' => '_phinx_log',
        'default_database' => getenv('DB_ADAPTER'),
        'mysql' => array(
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
            'port' => getenv('DB_PORT'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
        ),
        'sqlite' => array(
            'adapter' => 'sqlite',
            'name' => $siteRoot . getenv('DB_NAME')
        ),
    )
);
