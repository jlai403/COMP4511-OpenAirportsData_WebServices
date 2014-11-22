<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/Airport.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/DataAccess/PdoWrapper.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");

class AirportController extends BaseController{

    /*
     *  Finds an airport by country name.
     *
     *  GET /Country/{country-name}.{json|xml}
     *  {country-name}: Required
     */
    public function Country() {
        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                $country = $_GET["paramOne"];
                $responseDataType = $_GET["format"];
                if ($country === NULL || $responseDataType === NULL) {
                    $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Invalid country name or format selected.");
                    $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                }

                $query = "SELECT * FROM assignment4.airports WHERE Country LIKE '%$country%';";
                $resultSet = (new PdoWrapper())->executeQueryWithResultSet($query);
                $airports = $this->assembleAirportsFromResultSet($resultSet);

                $this->sendHttpResponse(HttpStatusCodes::OK, ContentTypes::JSON, json_encode($airports, JSON_PRETTY_PRINT));
                break;
            case "POST":
                $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Unknown request method.");
                $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                break;
            case "PUT":
                $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Unknown request method.");
                $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                break;
            case "DELETE":
                $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Unknown request method.");
                $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                break;
            default:
                $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Unknown request method.");
                $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                break;
        }
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

// invokes web api call
(new AirportController())->invokeAction($_GET["action"]);