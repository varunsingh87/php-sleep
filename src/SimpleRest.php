<?php

namespace VarunS\BorumSleep;

/**
 * A simple RESTful webservices base class
 */
class SimpleRest
{

	private static $httpVersion = "HTTP/1.1";

	/**
	 * Sets the HTTP headers, content type, access-control-allow-origin and charset headers
	 * @param int|string $statusCode The status code that will be passed into SimpleRest::getHttpStatusMessage
	 * @param string $contentType The Content-Type header value, defaults to application/json
	 */
	public static function setHttpHeaders($statusCode, $contentType = NULL)
	{
		$statusMessage = SimpleRest::getHttpStatusMessage($statusCode);

		header(SimpleRest::$httpVersion . " " . $statusCode . " " . $statusMessage);
		header("Content-Type:" . ($contentType ?? "application/json") . "; charset=UTF-8");

		// Needed for CORS Options request
		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN'] . '');
		header('Access-Control-Allow-Credentials: true');
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

	public static function handleNoApiKey()
	{
		if (!isset($_GET['app_api_key'])) {
			SimpleRest::setHttpHeaders(403); // Set header to forbidden error
			echo json_encode([
				"error" => [
					"message" => "The app client's registered API key must be specified in the URL with the parameter 'app_api_key'"
				]
			]);
			exit();
		}
	}

	/**
	 * Handle the validation of a serverless function's post parameters
	 * @param Array $requiredParameters The required POST parameters
	 */
	public static function handlePostParameterValidation(String ...$requiredParameters)
	{
		$errors = array();
		foreach ($requiredParameters as $paramName) {
			if (!isset($_POST[$paramName])) {
				array_push($errors, $paramName);
			}
		}
		if (sizeof($errors) > 0) {
			SimpleRest::setHttpHeaders(400);
			echo json_encode([
				"error" => [
					"message" => "The required POST parameters were not provided",
					"missingParameters" => $errors
				]
			]);
			exit();
		}
	}

	public static function handleDeleteParameterValidation(String ...$requiredParameters)
	{
		$errors = array();
		foreach ($requiredParameters as $paramName) {
			if (!isset($GLOBALS["_{DELETE}"][$paramName])) {
				array_push($errors, $paramName);
			}
		}

		if (sizeof($errors) > 0) {
			SimpleRest::setHttpHeaders(400);
			echo json_encode([
				"error" => [
					"message" => "The required DELETE parameters were not provided",
					"missingParameters" => $errors
				]
			]);
			exit();
		}
	}

	public static function handleHeaderValidation($headers, String ...$requiredHeaders)
	{
		$errors = array();

		foreach ($requiredHeaders as $header) {
			if (!isset($headers[$header])) {
				array_push($errors, $header);
			}
		}

		if (sizeof($errors) > 0) {
			SimpleRest::setHttpHeaders(401);
			echo json_encode([
				"error" => [
					"message" => "Access not authorized without proper headers",
					"missingHeaders" => $errors
				]
			]);
			exit();
		}
	}

	/**
	 * Validates and echos an error with status code 405 when an invalid request method is used
	 * @param Array $validRequestMethods The allowed request methods
	 */
	public static function handleRequestMethodValidation(String ...$validRequestMethods)
	{
		header("Access-Control-Allow-Methods: " . join(", ", $validRequestMethods));
		if (!in_array($_SERVER['REQUEST_METHOD'], $validRequestMethods)) {
			SimpleRest::setHttpHeaders(405);
			echo json_encode([
				"statusCode" => 405,
				"error" => [
					"message" => "Request method must be one of the following: " . join(", ", $validRequestMethods)
				]
			]);
			exit();
		}
	}


	/**
	 * Returns a 400 Bad Request error if the passed in id is not numeric
	 * @param int $id The id of the item
	 * @return Array statusCode 400 if not numeric and status code 100 if it is
	 */
	public static function handleNonNumericId($id, $prefix = "")
	{
		if (!is_numeric($id)) {
			return [
				"statusCode" => 400,
				"error" => [
					"message" => 'The ' . $prefix . 'id must be numeric'
				]
			];
		} else {
			return [
				"statusCode" => 100
			];
		}
	}

	/**
	 * Gets the usable value from the authorization header
	 * @param string $authorizationHeader The full string
	 * @return string The value after the text "Basic "
	 */
	public static function parseAuthorizationHeader($authorizationHeader): String
	{
		return substr($authorizationHeader, strlen("Basic "));
	}
}
