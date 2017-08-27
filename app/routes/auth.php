<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Portal\services\Auth;
use \Portal\Utils;

$app->group('/auth', function() {
    $this->post('/authenticate', function(Request $req, Response $res) {
        $auth = new Auth($this->db);
        $formData = $req->getParsedBody();
        $user = $auth->login($formData['email'], $formData['password']);
        if (!$user) {
            $this->flash->addMessage('Error', 'Kamu belum terdaftar');
        } else {
            Utils::setSession('user', $user);
        }
        return $res->withStatus(302)->withHeader('Location', '/');
    });

    $this->post('/logout', function(Request $req, Response $res) {
        Utils::removeSession('user');
        session_destroy();
        return $res->withStatus(302)->withHeader('Location', '/');
    });
});
