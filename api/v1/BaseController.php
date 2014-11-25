<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");

abstract class BaseController {
    public function invokeAction($action) {
        if(!method_exists($this, $action)) {
            $error = new HttpResponseObject(HttpStatusCodes::NOT_FOUND, "'$action' Not Found.");
            $this->sendHttpResponse($error->getStatusCode(), ContentTypes::JSON, json_encode($error));
        }

        call_user_func(array($this, $action));
    }

    protected function sendHttpResponse($responseCode, $contentType, $xmlOrJson){
        http_response_code($responseCode);
        header(sprintf("Content-type: %s", $contentType));
        echo $xmlOrJson;
        exit();
    }
} 