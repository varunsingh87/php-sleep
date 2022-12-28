<?php 

namespace VarunS\PHPSleep;

use \Exception;

class Route {
	public string $apiKey;
	
    public function __construct() {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

		if (!isset($_SERVER['HTTP_ORIGIN']))
			$_SERVER['HTTP_ORIGIN'] = 'localhost';

		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Headers: Authorization');
        header("Content-Type: application/json; charset=UTF-8");
		

    }

	public function authorize() {
		$headers = apache_request_headers();
		
		if (!isset($headers['authorization'])) {
			throw new Exception("Not authorized");
		}

		$this->apiKey = substr($headers['authorization'], sizeof("Basic "));
	}

    public function get(callback $get) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $response = $get();
            header("HTTP/1.1 200 OK");
			echo json_encode($response);
        }
    }

    	/**
	 * Gets the standard Http status message that corresponds to the passed in status code
	 * @param int|string $statusCode
	 * @return string The status message
	 */
	public static function getHttpStatusMessage($statusCode)
	{
		$httpStatus = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		);
		return $httpStatus[$statusCode] ?? $httpStatus[500];
	}
}