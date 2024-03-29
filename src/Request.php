<?php

namespace VarunS\PHPSleep;

class Request {
    private $headers;

    public function __construct() {
        $this->headers = apache_request_headers();
    }

    public function getHeader($name) {
        return $this->headers[$name];
    }

    public function hasHeader($name): bool {
        return isset($this->headers[$name]);
    }

    public function authorize() {
        return substr($this->getHeader('authorization'), strlen('Basic '));
    }
}