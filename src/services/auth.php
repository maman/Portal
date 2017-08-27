<?php

namespace Portal\services;

class Auth {
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    function login($email, $password) {
        $sql = "
        SELECT
            id,
            email,
            name
        FROM
            membership
        WHERE
            email = '$email'
        AND
            password = '$password'
        ";
        $result = $this->db->query($sql);
        if (count($result) == 1) {
            return [
                'id' => $result[0]['id'],
                'email' => $result[0]['email'],
                'name' => $result[0]['name'],
            ];
        }
        return false;
    }
}
