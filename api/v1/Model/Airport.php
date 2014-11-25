<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/XML/IWriteXml.php");

class Airport implements JsonSerializable, IWriteXml {

    private $name;
    private $city;
    private $country;
    private $faaCode;
    private $latitude;
    private $longitude;
    private $altitude;
    private $timeZone;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getFaaCode() {
        return $this->faaCode;
    }

    public function setFaaCode($faaCode) {
        $this->faaCode = $faaCode;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function getAltitude() {
        return $this->altitude;
    }

    public function setAltitude($altitude) {
        $this->altitude = $altitude;
    }

    public function getTimeZone() {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;
    }


    public function jsonSerialize()
    {
        return [
            'airport' => [
                'name' => $this->getName(),
                'city' => $this->getCity(),
                'country' => $this->getCountry(),
                'faa_code' => $this->getFaaCode(),
                'latitude' => $this->getLatitude(),
                'longitude' => $this->getLongitude(),
                'altitude' => $this->getAltitude(),
                'timezone' => $this->getTimeZone(),
            ]
        ];
    }

    public function assembleXmlElement(&$writer) {
        $writer->startElement('airport');
        $writer->writeElement('name', $this->getName());
        $writer->writeElement('city', $this->getCity());
        $writer->writeElement('country', $this->getCountry());
        $writer->writeElement('faa_code', $this->getFaaCode());
        $writer->writeElement('latitude', $this->getLatitude());
        $writer->writeElement('longitude', $this->getLongitude());
        $writer->writeElement('altitude', $this->getAltitude());
        $writer->writeElement('timezone', $this->getTimeZone());
        $writer->endElement();
    }
} 