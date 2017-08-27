<?php

namespace Portal\services;

use Ramsey\Uuid\Uuid;

use \Portal\services\Location;

class Berita extends Location {
    private $db;

    function __construct($db) {
        parent::__construct($db);
        $this->db = $db;
    }

    function create(
        $userid,
        $name,
        $titel,
        $deskripsi,
        $kategori,
        $attachment
    ) {}

    function get($kategori, $currentPage, $offset, $size) {}

    function update(
        $userid,
        $name,
        $titel,
        $deskripsi,
        $kategori,
        $attachment
    ) {}

    function delete($beritaId) {
        $sql = "
            DELETE
            FROM membership
            WHERE
                userid = '$userId'
        ";
        $this->db->exec($sql);
    }
}
