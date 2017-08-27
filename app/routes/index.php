<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Portal\Utils;

$app->get('/', function(Request $req, Response $res) {
    $viewData = [
        'loggedIn' => false,
    ];
    if (Utils::issetSession('user')) {
        $viewData['user'] = Utils::getSession('user');
        $viewData['loggedIn'] = true;
    };
    return $this->view->render($res, 'pages/_home.twig', $viewData);
});
