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
        $email,
        $password,
        $nama_lengkap,
        $tanggal_lahir,
        $region_code,
        $alamat,
        $hp
    ) {
        $id = Uuid::uuidv4();
        $userId = Uuid::uuidv4();
        $sql = "
        INSERT INTO
            membership
            (
                id, 
                userid,
                email,
                password,
                nama_lengkap,
                tanggal_lahir,
                region_code,
                alamat,
                hp
            )
        VALUES
            (
                '$id', 
                '$userId',
                '$email',
                '$password',
                '$nama_lengkap',
                '$tanggal_lahir',
                '$region_code',
                '$alamat',
                '$hp'
            )
        ";
        $db->exec($sql);
    }

    function getByUserId($userId) {
        $sql = "
            SELECT
                email,
                nama_lengkap,
                tanggal_lahir,
                membership.region_code,
                alamat,
                hp
            FROM
                membership,
                location
            WHERE
                membership.region_code = location.region_code
            AND
                membership.userid = '$userId'
        ";
        $result = $this->db->query($sql);
        return [
            email => $result[0]['email'],
            nama_lengkap => $result[0]['nama_lengkap'],
            tanggal_lahir => $result[0]['tanggal_lahir'],
            location => $this->parseRegionCode($result[0]['region_name']),
            alamat => $result[0]['alamat'],
            hp => $result[0]['hp'],
        ];
    }

    function update(
        $userId,
        $email,
        $password,
        $nama_lengkap,
        $tanggal_lahir,
        $region_code,
        $alamat,
        $hp
    ) {
        $sql = "
            UPDATE
                membership
            SET (
                    email,
                    password,
                    nama_lengkap,
                    tanggal_lahir,
                    region_code,
                    alamat,
                    hp
                )
            WHERE
                userid = '$userId'
        ";
        $this->db->exec($sql);
    }

    function deleteMember($userId) {
        $sql = "
            DELETE
            FROM membership
            WHERE
                userid = '$userId'
        ";
        $this->db->exec($sql);
    }
}
