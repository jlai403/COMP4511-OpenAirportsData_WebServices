<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/ContentTypes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Constants/HttpStatusCodes.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/php-ga/autoload.php");

use UnitedPrototype\GoogleAnalytics;

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

    protected function trackApiRequest($apiCall){
        // Initilize GA Tracker
        $tracker = new GoogleAnalytics\Tracker('UA-57190520-1', 'comp4511.jlai.ca');

        // Assemble Visitor information
        // (could also get unserialized from database)
        $visitor = new GoogleAnalytics\Visitor();
        $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
        $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $visitor->setScreenResolution('1024x768');

        // Assemble Session information
        // (could also get unserialized from PHP session)
        $session = new GoogleAnalytics\Session();

        // Assemble Page information
        $page = new GoogleAnalytics\Page('/'.$apiCall);
        $page->setTitle('My Page');

        // Track page view
        $tracker->trackPageview($page, $session, $visitor);
    }
} 