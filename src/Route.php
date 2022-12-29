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

    public function get(callable $get) {
		try {
			if ($_SERVER['REQUEST_METHOD'] === 'GET') {
				$response = $get(new Request);
				http_response_code(200);
				echo json_encode($response);
			}
		} catch (\Throwable $e) {
			http_response_code($e->getCode());
			return [
				"error" => [
					"message" => $e->getMessage()
				]
			];
		}
    }

	public function post(callable $post) {
		try {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$response = $post(new Request);
				echo json_encode($response);
			}
		} catch (\Throwable $e) {
			http_response_code($e->getCode());
			return [
				"error" => [
					"message" => $e->getMessage()
				]
			];
		}

	}
}