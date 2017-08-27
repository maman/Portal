<?php

namespace Portal\middleware;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Portal\Utils;

class Auth {
    private $app;

    function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(Request $req, Response $res, callable $next) {
        if (!Utils::issetSession('user')) {
            
        } else {
            
        }
    }
}
