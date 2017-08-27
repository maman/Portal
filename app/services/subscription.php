<?php

namespace Portal\services;

class Subscription {
    private $db;
    private $logger;

    function __construct($db, $logger) {
        $this->db = $db;
        $this->logger = $logger;
    }

    function create() {}

    function delete() {}

    function get() {}
}
