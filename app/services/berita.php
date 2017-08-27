<?php

namespace Portal\services;

use Ramsey\Uuid\Uuid;

use \Portal\services\Location;

class Berita extends Location {
    private $db;
    private $logger;

    function __construct($db, $logger) {
        parent::__construct($db, $logger);
        $this->db = $db;
        $this->logger = $logger;
    }

    function create(
        $userId,
        $name,
        $titel,
        $deskripsi,
        $kategori,
        $attachment
    ) {
        $sql='
            INSERT INTO berita
            VALUES
                (
                    id = :id,
                    userid = :userId,
                    name = :name,
                    titel = :titel,
                    deskripsi = :deskripsi,
                    kategori = :kategori,
                    attachment = :attachment
                )
        ';
        try {
            $id = Uuid::uuidv4()->toString();
            $statement = $this->db->prepare($sql);
            $statement->bindParam('id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam('userId', $userId, PDO::PARAM_STR, 36);
            $statement->bindParam('titel', $titel, PDO::PARAM_STR, 140);
            $statement->bindParam('deskripsi', $deskripsi, PDO::PARAM_STR);
            $statement->bindParam('kategori', $kategori, PDO::PARAM_STR, 140);
            $statement->bindParam('attachment', $attachment, PDO::PARAM_STR, 255);
            $statement->execute();
        } catch (PDOException $e) {
            $message = $e->getMessage();
            $this->logger->error("Berita::create - '$userId', '$name', '$titel', '$deskripsi', '$kategori', '$attachment' - '$message'");
            return false;
        }
    }

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
