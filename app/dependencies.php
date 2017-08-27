<?php

$container = $app->getContainer();

$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

if (!$isProduction) {
    $container['twig_profiler'] = function() {
        return new Twig_Profiler_Profile();
    };
}

$container['view'] = function($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => $settings['cache'],
        'debug' => $settings['debug'],
        'auto_reload' => $settings['auto_reload'],
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c->get('router'),
        $c->get('request')->getUri()
    ));
    if (!$isProduction) {
        $view->addExtension(new Twig_Extension_Profiler($c['twig_profiler']));
        $view->addExtension(new Twig_Extension_Debug());
    }
    return $view;
};

$container['logger'] = function($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new \PDO('mysql:host=' . $settings['dbHost'] . ';dbname=' . $settings['dbName'], $settings['dbUser'], $settings['dbPasswd']);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
};

if (!$isProduction) {
    $app->add(new \RunTracy\Middlewares\TracyMiddleware($app));
}
