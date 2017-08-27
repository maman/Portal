<?php

session_start();

$appSettings = require __DIR__ . '/settings.php';

$app = new \Slim\App($appSettings);

require __DIR__ . '/dependencies.php';

foreach (glob(__DIR__ . '/routes/*.php') as $route) {
    require $route;
}

$app->run();
