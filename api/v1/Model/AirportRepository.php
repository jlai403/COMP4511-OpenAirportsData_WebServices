<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/DataAccess/PdoWrapper.php");

class AirportRepository {

    public function findByCountry($country, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $query = "SELECT * FROM assignment4.airports WHERE Country LIKE '%$country%' $limitQuery;";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByCity($city, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $query = "SELECT * FROM assignment4.airports WHERE City LIKE '%$city%' $limitQuery;";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByIATA($iata, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $query = "SELECT * FROM assignment4.airports WHERE IATA_FAA = '$iata' $limitQuery;";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByName($name, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $query = "SELECT * FROM assignment4.airports WHERE Name like '%$name%' $limitQuery;";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByAltitude($altitude, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $query = "SELECT * FROM assignment4.airports WHERE Altitude = '$altitude' $limitQuery;";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByRadius($distance, $lat, $long, $limit){
        $limitQuery = $limit === "" ? "" : " limit $limit";

        $radius = 6371; // earths radius in km

        $minLat = $lat - rad2deg($distance / $radius);
        $maxLat = $lat + rad2deg($distance / $radius);
        $minLong = $long - rad2deg($distance / $radius / cos(deg2rad($lat)));
        $maxLong = $long + rad2deg($distance / $radius / cos(deg2rad($lat)));

        $query = "
            SELECT *
            FROM assignment4.airports
            WHERE (Latitude BETWEEN $minLat AND $maxLat)
            AND (Longitude BETWEEN $minLong AND $maxLong)
            $limitQuery
        ;";

        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);
    }

    private function assembleAirportsFromResultSet($resultSet) {
        $airports = array();
        foreach($resultSet as $record) {
            $airport = new Airport();
            $airport->setName($record['Name']);
            $airport->setCity($record['City']);
            $airport->setCountry($record['Country']);
            $airport->setIataCode($record['IATA_FAA']);
            $airport->setLatitude($record['Latitude']);
            $airport->setLongitude($record['Longitude']);
            $airport->setAltitude($record['Altitude']);
            $airport->setTimeZone($record['Timezone']);
            array_push($airports, $airport);
        }
        return $airports;
    }
} 