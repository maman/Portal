<?php

use Tracy\Debugger;

$basedir = __DIR__ . '/../';
$appName = 'php-slim';
$isProduction = getenv('PHP_ENV') == 'production' ? true : false;

if (!$isProduction) {
    Debugger::enable(Debugger::DEVELOPMENT, $basedir . 'logs');
} else {
    Debugger::enable(Debugger::PRODUCTION, $basedir . 'logs');
}

error_reporting($isProduction ? 'E_ALL' : 'E_ALL');
ini_set('display_errors', !$isProduction);
ini_set('log_errors', !$isProduction);
ini_set('error_log', $basedir . 'logs/' . $appName . '-php.log');
date_default_timezone_set(getenv('PHP_APP_LOCALE'));

return [
    'isProduction' => $isProduction,
    'settings' => [
        'displayErrorDetails' => !$isProduction,
        'determineRouteBeforeAppMiddleware' => !$isProduction,
        'addContentLengthHeader' => false,
        'tracy' => [
            'showPhpInfoPanel' => 0,
            'showSlimRouterPanel' => 1,
            'showSlimEnvironmentPanel' => 0,
            'showSlimRequestPanel' => 1,
            'showSlimResponsePanel' => 1,
            'showSlimContainer' => 0,
            'showTwigPanel' => 1,
            'showVendorVersionsPanel' => 0,
            'showXDebugHelper' => 1,
            'showIncludedFiles' => 1,
            'showConsolePanel' => 0,
            'configs' => [
                'XDebugHelperIDEKey' => 'PHPSTORM',
                'ConsoleNoLogin' => 0,
                'ConsoleAccounts' => [
                    'dev' => '34c6fceca75e456f25e7e99531e2425c6c1de443'// = sha1('dev')
                ],
                'ConsoleHashAlgorithm' => 'sha1',
                'ConsoleHomeDirectory' => $basedir,
                'ProfilerPanel' => [
                    'show' => [
                        'memoryUsageChart' => 1, // or false
                        'shortProfiles' => true, // or false
                        'timeLines' => true // or false
                    ]
                ]
            ]
        ],
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
