<?php

class HttpResponseObject implements JsonSerializable {
    private $statusCode;
    private $statusDescription;

    public function __construct($statusCode, $statusDescription) {
        $this->setStatusCode($statusCode);
        $this->setStatusDescription($statusDescription);
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function getStatusDescription() {
        return $this->statusDescription;
    }

    public function setStatusDescription($statusDescription) {
        $this->statusDescription = $statusDescription;
    }

    function jsonSerialize()
    {
        return [
            'httpResponse' => [
                'statusCode' => $this->getStatusCode(),
                'statusDescription' => $this->getStatusDescription()
            ]
        ];
    }
} 