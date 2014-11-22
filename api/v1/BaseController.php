<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");

abstract class BaseController {
    public function invokeAction($action) {
        call_user_func(array($this, $action));
    }

    protected function sendHttpResponse($responseCode, $contentType, $xmlOrJson){
        http_response_code($responseCode);
        header(sprintf("Content-type: %s", $contentType));
        echo $xmlOrJson;
        exit();
    }
} 