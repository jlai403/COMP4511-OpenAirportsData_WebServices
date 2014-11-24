<?php

class AirportRepository {

    public function findByCountry($country){
        $query = "SELECT * FROM assignment4.airports WHERE Country LIKE '%$country%';";
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
            $airport->setFaaCode($record['IATA_FAA']);
            $airport->setLatitude($record['Latitude']);
            $airport->setLongitude($record['Longitude']);
            $airport->setAltitude($record['Altitude']);
            $airport->setTimeZone($record['Timezone']);
            array_push($airports, $airport);
        }
        return $airports;
    }
} 