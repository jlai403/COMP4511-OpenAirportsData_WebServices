<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/api/v1/BaseController.php");

class AirportController extends BaseController{


    public function testApiCall(){
        echo "made it into testApiCall";

    }
}

// invokes web api call
(new AirportController())->invokeAction($_GET["action"]);