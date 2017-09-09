<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Portal\Utils;

$app->get('/register', function (Request $req, Response $res) {
    return $this->view->render($res, 'pages/register.twig');
});
