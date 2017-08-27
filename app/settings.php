<?php

$basedir = __DIR__ . '/../';
$appName = 'php-slim';
$isProduction = getenv('PHP_ENV') == 'production' ? true : false;

error_reporting($isProduction ? 'E_ALL' : 'E_ALL');
ini_set('display_errors', !$isProduction);
ini_set('log_errors', !$isProduction);
ini_set('error_log', $basedir . 'logs/' . $appName . '-php.log');
date_default_timezone_set(getenv('PHP_APP_LOCALE'));

return [
    'isProduction' => $isProduction,
    'settings' => [
        'displayErrorDetails' => !$isProduction,
        'addContentLengthHeader' => true,
        'renderer' => [
            'template_path' => $basedir . 'app/views',
            'cache' => $basedir . 'app/views-cache',
            'debug' => !$isProduction,
            'auto_reload' => !$isProduction,
        ],
        'logger' => [
            'name' => $appName,
            'path' => $basedir . 'logs/' . $appName . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'dbHost' => getenv('MYSQL_HOST'),
            'dbRootPasswd' => getenv('MYSQL_ROOT_PASSWORD'),
            'dbName' => getenv('MYSQL_DATABASE'),
            'dbUser' => getenv('MYSQL_USER'),
            'dbPasswd' => getenv('MYSQL_PASSWORD'),
        ],
    ],
];
