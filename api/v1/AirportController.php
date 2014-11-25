<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/Airport.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/AirportRepository.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/HttpResponseObject.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/DataAccess/PdoWrapper.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ErrorConstants.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/XML/XmlWriterWrapper.php");

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
                $country = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined country.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $airports = (new AirportRepository())->findByCountry($country);
                $this->sendAirportsResponse($airports, $responseDataType);
                break;
            case "POST":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "PUT":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "DELETE":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            default:
                $this->sendBadRequestResponse("Unknown request method.");
                break;
        }
    }

    /*
     *  Finds an airport by city name.
     *
     *  GET /City/{city-name}.{json|xml}
     *  {city-name}: Required
     */
    public function City()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $city = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined city.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $airports = (new AirportRepository())->findByCity($city);
                $this->sendAirportsResponse($airports, $responseDataType);
                break;
            case "POST":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "PUT":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "DELETE":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            default:
                $this->sendBadRequestResponse("Unknown request method.");
                break;
        }
    }

    /*
     *  Finds an airport by IATA (3 letter code).
     *
     *  GET /IATA/{3-letter-code}.{json|xml}
     *  {3-letter-code}: Required
     */
    public function IATA()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $iata = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined IATA (3 letter code).");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $airports = (new AirportRepository())->findByIATA($iata);
                $this->sendAirportsResponse($airports, $responseDataType);
                break;
            case "POST":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "PUT":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "DELETE":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            default:
                $this->sendBadRequestResponse("Unknown request method.");
                break;
        }
    }

    /*
     *  Finds an airport within defined radius of latitude and longitude.
     *
     *  GET /Radius/{distance-km}.{json|xml}?lat={latitude}&long={longitude}
     *  {distance-km}: Required
     *  {latitude}: Required
     *  {longitude}: Required
     */
    public function Radius()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $distance = isset($_GET["paramOne"]) ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined distance (km).");
                $lat = isset($_GET["lat"]) ? $_GET["lat"] : $this->sendBadRequestResponse("Undefined latitude.");
                $long = isset($_GET["long"]) ? $_GET["long"] : $this->sendBadRequestResponse("Undefined longitude.");
                $responseDataType = isset($_GET["format"]) ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $airports = (new AirportRepository())->findByRadius($distance, $lat, $long);
                $this->sendAirportsResponse($airports, $responseDataType);
                break;
            case "POST":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "PUT":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            case "DELETE":
                $this->sendBadRequestResponse("Unknown request method.");
                break;
            default:
                $this->sendBadRequestResponse("Unknown request method.");
                break;
        }
    }

    private function sendBadRequestResponse($errorMessage){
        $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, $errorMessage);
        $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
    }

    private function sendAirportsResponse($airports, $responseDataType){
        switch($responseDataType){
            case "json":
                $this->sendHttpResponse(HttpStatusCodes::OK, ContentTypes::JSON, json_encode($airports, JSON_PRETTY_PRINT));
                break;
            case "xml":
                $xml = (new XmlWriterWrapper())->GenerateXmlFromList("airports", $airports);
                $this->sendHttpResponse(HttpStatusCodes::OK, ContentTypes::XML, $xml);
                break;
            default:
                $this->sendBadRequestResponse("Format type unknown.");
        }
    }
}

// invokes web api call
(new AirportController())->invokeAction($_GET["action"]);