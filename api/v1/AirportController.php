<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/Airport.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/AirportRepository.php");
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

                $airports = (new AirportRepository())->findByCountry($country);

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

    /*
     *  Finds an airport by city name.
     *
     *  GET /Country/{city-name}.{json|xml}
     *  {city-name}: Required
     */
    public function City()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $city = $_GET["paramOne"];
                $responseDataType = $_GET["format"];
                if ($city === NULL || $responseDataType === NULL) {
                    $error = new HttpResponseObject(HttpStatusCodes::BAD_REQUEST, "Invalid city name or format selected.");
                    $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
                }

                $airports = (new AirportRepository())->findByCity($city);

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
}

// invokes web api call
(new AirportController())->invokeAction($_GET["action"]);