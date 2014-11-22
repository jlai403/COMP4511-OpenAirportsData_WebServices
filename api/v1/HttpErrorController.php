<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/Model/HttpResponseObject.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");

class HttpErrorController extends BaseController{

    public function NotFound() {
        $error = new HttpResponseObject(HttpStatusCodes::NOT_FOUND, "Request was not found.");
        $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
    }
}

// invokes web api call
(new HttpErrorController())->invokeAction($_GET["action"]);