<?php

namespace Portal\services;

use Ramsey\Uuid\Uuid;

use \Portal\services\Location;

class Kerjaan extends Location {
    private $db;
    private $logger;

    function __construct($db, $logger) {
        parent::__construct($db, $logger);
        $this->db = $db;
        $this->logger = $logger;
    }

    function create(
        $userid,
        $companyName,
        $type,
        $titel,
        $remote,
        $regionCode,
        $deskripsi,
        $expiry
    ) {
        $sql = "
            INSERT INTO
                kerjaan
                (
                    id,
                    userid,
                    company_name,
                    type,
                    titel,
                    remote,
                    region_code,
                    deskripsi,
                    expiry
                )
            VALUES
                (
                    :userId,
                    :companyName,
                    :type,
                    :titel,
                    :remote,
                    :regionCode,
                    :deskripsi,
                    :expiry,
                )
        ";
        try {
            $statements = $this->db->prepare($sql);
        } catch (PDOException $e) {
            return false;
        }
    }

    function get($kategori, $remote, $regionCode, $currentPage, $offset, $size) {}

    function getDetail($kerjaanId) {}
    
    function editDetail($kerjaanId) {}

    function delete($kerjaanId) {}
}
