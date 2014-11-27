<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/Airport.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/AirportRepository.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/HttpResponseObject.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ErrorConstants.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/XML/XmlWriterWrapper.php");

class AirportController extends BaseController{

    /*
     *  Finds an airport by country name.
     *
     *  GET /Country/{country-name}.{json|xml}?limit={limit}
     *  {country-name}: Required
     *  {limit}: Optional
     */
    public function Country() {
        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                $country = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined country.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByCountry($country, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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
     *  GET /City/{city-name}.{json|xml}?limit={limit}
     *  {city-name}: Required
     *  {limit}: Optional
     */
    public function City()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $city = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined city.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByCity($city, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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
     *  GET /IATA/{3-letter-code}.{json|xml}?limit={limit}
     *  {3-letter-code}: Required
     *  {limit}: Optional
     */
    public function IATA()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $iata = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined IATA (3 letter code).");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByIATA($iata, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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
    *  Finds an airport by Name.
    *
    *  GET /Name/{airport-name}.{json|xml}?limit={limit}
    *  {airport-name}: Required
    *  {limit}: Optional
    */
    public function Name()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $name = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined name for airport.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByName($name, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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
    *  Finds an airport by altitude.
    *
    *  GET /Altitude/{altitude}.{json|xml}?limit={limit}
    *  {altitude}: Required
    *  {limit}: Optional
    */
    public function Altitude()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $altitude = $_GET["paramOne"] ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined altitude.");
                $responseDataType = $_GET["format"] ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);
                if (!is_numeric($altitude)) {
                    $this->sendBadRequestResponse("Altitude '$altitude', is invalid.");
                }

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByAltitude($altitude, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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
     *  GET /Radius/{distance-km}.{json|xml}?lat={latitude}&long={longitude}&limit={limit}
     *  {distance-km}: Required
     *  {latitude}: Required
     *  {longitude}: Required
     *  {limit}: Optional
     */
    public function Radius()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $distance = isset($_GET["paramOne"]) ? $_GET["paramOne"] : $this->sendBadRequestResponse("Undefined distance (km).");
                $lat = isset($_GET["lat"]) ? $_GET["lat"] : $this->sendBadRequestResponse("Undefined latitude.");
                $long = isset($_GET["long"]) ? $_GET["long"] : $this->sendBadRequestResponse("Undefined longitude.");
                $responseDataType = isset($_GET["format"]) ? $_GET["format"] : $this->sendBadRequestResponse(ErrorConstants::UNDEFINED_FORMAT_TYPE_MESSAGE);

                $limit = isset($_GET["limit"]) ? $_GET["limit"] :  "";
                $airports = (new AirportRepository())->findByRadius($distance, $lat, $long, $limit);
                $this->sendSuccessAirportsResponse($airports, $responseDataType);
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

    private function sendSuccessAirportsResponse($airports, $responseDataType){
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