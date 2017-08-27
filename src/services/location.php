<?php

namespace Portal\services;

class Location {
    private $db;
    private $logger;

    function __construct($db, $logger) {
        $this->db = $db;
        $this->logger = $logger;
    }

    function parseRegionCode($regionCode) {
        $sql = '
            SELECT
                region_name
            FROM
                location
            WHERE
                region_code IN (
                    :province,
                    :city,
                    :district,
                    :subdistrict,
                )
            ORDER BY
                region_code
        ';
        try {
            $explodedRegionCode = explode('.', $regionCode);
            $province = $explodedRegionCode[0];
            $city = $explodedRegionCode[0] . '.' . $explodedRegionCode[1];
            $district = $explodedRegionCode[0] . '.' . $explodedRegionCode[1] . '.' . $explodedRegionCode[2];
            $subDistrict = $regionCode;
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':province', $province, PDO::PARAM_STR, 2);
            $statement->bindParam(':city', $province, PDO::PARAM_STR, 5);
            $statement->bindParam(':district', $province, PDO::PARAM_STR, 8);
            $statement->bindParam(':subdistrict', $regionCode, PDO::PARAM_STR, 13);
            $statement->execute();
            $result = $statement->fetchAll();
            return [
                'province' => $result[0]['region_name'] . ':' . $provice,
                'city' => $result[1]['region_name'] . ':' . $city,
                'district' => $result[2]['region_name'] . ':' . $district,
                'subDistrict' => $result[3]['region_name'] . ':' . $subDistrict,
                'regionCode' => $regionCode,
            ];
        } catch (PDOException $e) {
            $message = $e->getMessage();
            $this->logger->error("Location::parseRegionCode : '$regionCode' : '$message'");
            return false;
        }
    }

    function getLocations($regionCode) {
        $sql = '
            SELECT
                region_code,
                region_name,
                parent_code
            FROM
                tbl_regions
            WHERE
                parent_code = :regionCode
        ';
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':regionCode', $regionCode, PDO::PARAM_STR, 13);
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            $message = $e->getMessage();
            $this->logger->error("Location::getLocations : '$regionCode' : '$message'");
            return false;
        }
    }
}
