<?php

namespace Portal\services;

use Ramsey\Uuid\Uuid;

use \Portal\services\Location;

class Membership extends Location {
    private $db;
    private $logger;

    function __construct($db, $logger) {
        parent::__construct($db, $logger);
        $this->db = $db;
        $this->logger = $logger;
    }

    private function createAlamat(
        $userId,
        $regionCode,
        $alamat
    ) {
        $id = Uuid::uuidv4()->toString();
        $sql = '
            INSERT INTO
                membership-current-alamat
                (
                    id,
                    userid,
                    region_code,
                    alamat,
                )
            VALUES
                (
                    :id,
                    :userId,
                    :regionCode,
                    :alamat
                )
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->bindParam(':regionCode', $regionCode, PDO::PARAM_STR, 15);
            $statement->bindParam(':alamat', $alamat, PDO::PARAM_STR, 500);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__createAlamat : '$id', '$userId', '$regionCode', '$alamat'");
            return false;
        }
    }

    private function getAlamat($userId) {
        $sql = '
            SELECT
                id,
                region_code,
                alamat
            FROM
                membership-current-alamat
            WHERE
                userid = :userId
            
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
            $alamats = $statement->fetchAll();
            if (count($alamats)) {
                return array_map(function($alamat) {
                    return [
                        id => $alamat['id'],
                        location => $this->parseRegionCode($alamat['region_code']),
                        alamat => $alamat['alamat'],
                    ];
                }, $alamats);
            }
            return [];
        } catch (PDOException $e) {
            $this->logger->error("Membership::__getAlamat : '$userId'");
            return false;
        }
    }

    private function updateAlamat(
        $id,
        $userid,
        $regionCode,
        $alamat
    ) {
        $sql = '
            UPDATE
                membership-current-location
            SET (
                region_code = :regionCode,
                alamat = :alamat
            )
            WHERE
                id = :id
            AND
                userid = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam(':userId', $userid, PDO::PARAM_STR, 36);
            $statement->bindParam(':regionCode', $regionCode, PDO::PARAM_STR, 15);
            $statement->bindParam(':alamat', $alamat, PDO::PARAM_STR, 500);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__updateAlamat : '$id', '$userId', '$regionCode', '$alamat'");
            return false;
        }
    }

    private function deleteAlamat($userId) {
        $sql = '
            DELETE FROM membership-current-alamat
            WHERE
                userid = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__deleteAlamat : '$userId'");
            return false;
        }
    }

    private function createSocmed(
        $userId,
        $type,
        $username
    ) {
        $id = Uuid::uuidv4()->toString();
        $sql = '
            INSERT INTO
                membership-socmed
                (
                    id,
                    userid,
                    type,
                    username,
                )
            VALUES
                (
                    :id,
                    :userId,
                    :type,
                    :username
                )
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->bindParam(':type', $type, PDO::PARAM_STR, 100);
            $statement->bindParam(':username', $username, PDO::PARAM_STR, 255);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__createSocmed : '$id', '$userId', '$type', '$username'");
            return false;
        }
    }

    private function getSocmed($userId) {
        $sql = '
            SELECT
                id,
                type,
                username
            FROM
                membership-socmed
            WHERE
                userid = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
            $socmeds = $statement->fetchAll();
            if (count($socmeds)) {
                return array_map(function($socmed) {
                    return [
                        id => $socmed['id'],
                        type => $socmed['type'],
                        username => $socmed['alamat'],
                    ];
                }, $alamats);
            }
            return [];
        } catch (PDOException $e) {
            $this->logger->error("Membership::__getSocmed : '$userId'");
            return false;
        }
    }

    private function updateSocmed(
        $id,
        $userid,
        $type,
        $username
    ) {
        $sql = '
            UPDATE
                membership-current-location
            SET (
                type = :type,
                username = :username
            )
            WHERE
                id = :id
            AND
                userid = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->bindParam(':type', $type, PDO::PARAM_STR, 100);
            $statement->bindParam(':username', $username, PDO::PARAM_STR, 255);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__updateSocmed : '$id', '$userId', '$type', '$username'");
            return false;
        }
    }

    private function deleteSocmed($userId) {
        $sql = '
            DELETE FROM membership-socmed
            WHERE
                userid = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
        } catch (PDOException $e) {
            $this->logger->error("Membership::__deleteSocmed : '$userId'");
            return false;
        }
    }

    private function getSubscribedKerjaan($userId) {
        $sql='
            SELECT
                kerjaan.company_name,
                kerjaan.kategori,
                kerjaan.title,
            FROM
                kerjaan-subscriber,
                kerjaan
            WHERE
                kerjaan.id = kerjaan-subscriber.kerjaanid
            AND
                kerjaan-subscriber.userid = :userId
        ';
    }

    private function deleteAllSubscribedKerjaan($userId) {
        $sql='
            DELETE FROM
                kerjaan-subscriber
            WHERE
                userid = :userId
        ';
    }

    function create(
        $email,
        $password,
        $namaLengkap,
        $namaPanggilan,
        $tanggalLahir,
        $regionCode,
        $alamat,
        $hp,
        $socmeds
    ) {
        $sql = '
        INSERT INTO
            membership
            (
                id,
                email,
                password,
                nama_lengkap,
                nama_panggilan,
                tanggal_lahir,
                hp
            )
        VALUES
            (
                :id,
                :email,
                :password,
                :namaLengkap,
                :tanggalLahir,
                :hp,
            )
        ';
        try {
            $id = Uuid::uuidv4()->toString();
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR, 36);
            $statement->bindParam(':email', $email, PDO::PARAM_STR, 100);
            $statement->bindParam(':password', $password, PDO::PARAM_STR, 255);
            $statement->bindParam(':namaLengkap', $namaLengkap, PDO::PARAM_STR, 255);
            $statement->bindParam(':namaPanggilan', $namaPanggilan, PDO::PARAM_STR, 36);
            $statement->bindParam(':tanggalLahir', $tanggalLahir, PDO::PARAM_STR);
            $statement->bindParam(':hp', $hp, PDO::PARAM_INT, 13);
            $statement->execute();
            $this->createAlamat($userId, $regionCode, $alamat);
            if (count($socmeds)) {
                foreach ($socmeds as $socmed) {
                    $subQuery = $this->createSocmed($socmed);
                    if (!$subQuery) {
                        break;
                        return false;
                    }
                }
            }
        } catch (PDOException $e) {
            $this->logger->error("Membership::create : '$email', '$password', '$namaLengkap', '$namaPanggilan', '$tanggalLahir', '$regionCode', '$alamat', '$hp', '$socmeds'");
            return false;
        }
    }

    function get($currentPage, $offset, $size) {
        try {
            $total = $this->db
                ->query('SELECT count(id) as rows FROM membership')
                ->fetch(PDO::FETCH_OBJ);
            $members = $total->rows;
            $pages = ceil($members / $size);
            $realOffset = filter_var($currentPage, FILTER_VALIDATE_INT, [
                'options' => [
                    'default' => 1,
                    'min_range' => 1,
                    'max_range' => $pages,
                ],
            ]);
            $range = $offset * ($currentPage - 1);
            $statement = $this->db->prepare('
                SELECT
                    nama_lengkap,
                    nama_panggilan,
                    gambar
                FROM
                    membership
                LIMIT
                    :range, :size
            ');
            $statement->bindParam(':range', $range, PDO::PARAM_INT);
            $statement->bindParam(':size', $size, PDO::PARAM_INT);
            $statement->execute();
            return [
                'currentPage' => $currentPage,
                'members' => $statement->fetchAll(),
                'nextPage' => $currentPage + 1 >= $members ? false : true,
            ];
        } catch (PDOException $e) {
            $message = $e->getMessage();
            $this->logger->error("Membership::get : '$offset', '$size' : '$message'");
        }
    }

    function getDetail($userId) {
        $sql = '
            SELECT
                email,
                gambar,
                nama_lengkap,
                nama_panggilan,
                tanggal_lahir,
                hp
            FROM
                membership
            WHERE
                id = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
            $result = $statement->fetchAll();
            $resultAlamat = $this->getAlamat($userId);
            $resultSocmed = $this->getSocmed($userId);
            if (!$resultAlamat || !$resultSocmed) {
                return false;
            }
            return [
                email => $result[0]['email'],
                gambar => $result[0]['gambar'],
                nama_lengkap => $result[0]['nama_lengkap'],
                nama_panggilan => $result[0]['nama_panggilan'],
                tanggal_lahir => $result[0]['tanggal_lahir'],
                location_history => $resultAlamat,
                alamat => $result[0]['alamat'],
                hp => $result[0]['hp'],
                socmeds => $resultSocmed,
            ];
        } catch (PDOException $e) {
            $this->logger->error("Membership::getDetail : '$userId'");
            return false;
        }
    }

    function editDetail(
        $userId,
        $email,
        $password,
        $namaLengkap,
        $namaPanggilan,
        $tanggalLahir,
        $hp,
        $alamats,
        $socmeds
    ) {
        $sql = '
            UPDATE
                membership
            SET (
                    email = :email,
                    password = :password,
                    nama_lengkap = :namaLengkap,
                    nama_panggilan = :namaPanggilan,
                    tanggal_lahir = :tanggalLahir,
                    hp = :hp,
                )
            WHERE
                id = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->bindParam(':email', $email, PDO::PARAM_STR, 100);
            $statement->bindParam(':password', $password, PDO::PARAM_STR, 255);
            $statement->bindParam(':namaLengkap', $namaLengkap, PDO::PARAM_STR, 255);
            $statement->bindParam(':namaPanggilan', $namaPanggilan, PDO::PARAM_STR, 36);
            $statement->bindParam(':tanggalLahir', $tanggalLahir, PDO::PARAM_STR);
            $statement->bindParam(':hp', $hp, PDO::PARAM_INT, 13);
            $statement->execute();
            if (count($alamats)) {
                foreach ($alamats as $alamat) {
                    $resultAlamat = $this->updateAlamat(
                        $alamat['id'],
                        $userId,
                        $alamat['regionCode'],
                        $alamat['alamat']
                    );
                    if (!$resultAlamat) {
                        break;
                        return false;
                    }
                }
            }
            if (count($socmeds)) {
                foreach ($socmeds as $socmed) {
                    $resultSocmed = $this->updateSocmed(
                        $socmed['id'],
                        $userId,
                        $socmed['type'],
                        $socmed['username']
                    );
                    if (!$resultSocmed) {
                        break;
                        return false;
                    }
                }
            }
        } catch (PDOException $e) {
            $this->logger->error("Membership::update : '$email', '$password', '$namaLengkap', '$namaPanggilan', '$tanggalLahir', '$regionCode', '$alamat', '$hp', '$socmeds'");
            return false;
        }
    }

    function delete($userId) {
        $sql = '
            DELETE
            FROM membership
            WHERE
                id = :userId
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':userId', $userId, PDO::PARAM_STR, 36);
            $statement->execute();
            $resultAlamat = $this->deleteAlamat($userId);
            $resultSocmed = $this->deleteSocmed($userId);
            $resultSubscriber = $this->deleteAllSubscribedKerjaan($userId);
            if (!$resultAlamat || !$resultSocmed || $resultSubscriber) {
                return false;
            }
        } catch (PDOException $e) {
            $this->logger->error("Membership::delete : '$userId'");
            return false;
        }
    }

    function subscribeKerjaan($userId, $kerjaanId) {
        $sql='
            INSERT INTO
                kerjaan-subscriber
            VALUES
                (
                    id = :id,
                    userid = :userId,
                    kerjaanid = :kerjaanId
                )
        ';
    }

    function unsubscribeKerjaan($subscribedKerjaanId) {
        $sql='
            DELETE FROM
                kerjaan-subscriber
            WHERE
                id = :subscribedKerjaanId
        ';
    }
}
