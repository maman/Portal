<?php

namespace Portal\services;

class Location {
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    // NEED FULL REGION CODE
    function parseRegionCode($regionCode) {
        $explodedRegionCode = explode('.', $regionCode);
        $sql = "
            SELECT
                region_name
            FROM
                location
            WHERE
                region_code IN (
                    '$explodedRegionCode[0]',
                    '$explodedRegionCode[0].$explodedRegionCode[1]',
                    '$explodedRegionCode[0].$explodedRegionCode[1].$explodedRegionCode[2]',
                    '$regionCode',
                )
            ORDER BY
                region_code
        ";
        $result = $this->db->query($sql);
        return [
            'province' => $result[0]['region_name'] . ':' . $explodedRegionCode[0],
            'city' => $result[1]['region_name'] . ':' . $explodedRegionCode[0] . '.' . $explodedRegionCode[1],
            'district' => $result[2]['region_name'] . ':' . $explodedRegionCode[0] . '.' . $explodedRegionCode[1] . '.' . $explodedRegionCode[2],
            'subDistrict' => $result[3]['region_name'] . ':' . $explodedRegionCode[0] . '.' . $explodedRegionCode[1] . '.' . $explodedRegionCode[2] . '.' . $explodedRegionCode[3],
            'regionCode' => $regionCode,
        ];
    }
}
