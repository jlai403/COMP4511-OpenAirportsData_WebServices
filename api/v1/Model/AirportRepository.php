<?php

class AirportRepository {

    public function findByCountry($country){
        $query = "SELECT * FROM assignment4.airports WHERE Country LIKE '%$country%';";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByCity($city){
        $query = "SELECT * FROM assignment4.airports WHERE City LIKE '%$city%';";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByIATA($iata){
        $query = "SELECT * FROM assignment4.airports WHERE IATA_FAA = '$iata';";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByName($name){
        $query = "SELECT * FROM assignment4.airports WHERE Name like '%$name%';";
        $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
        return $this->assembleAirportsFromResultSet($resultSet);

    }

    public function findByRadius($distance, $lat, $long){
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