<?php

namespace VarunS\PHPSleep;

class EndpointResponse
{
    public static function outputSuccessWithData($data)
    {
        return [
            "statusCode" => 200,
            "data" => $data
        ];
    }

    public static function outputSuccessWithoutData()
    {
        return [
            "statusCode" => 204
        ];
    }

    public static function outputSpecificErrorMessage(int $statusCode, string $errorMessage, $query = NULL, string $devMessage = NULL)
    {
        if ($statusCode >= 200 && $statusCode < 300) {
            throw new \InvalidArgumentException("The status code must be erroneous");
        }

        $response = [
            "statusCode" => $statusCode,
            "error" => [
                "message" => $errorMessage,
                "dev" => $devMessage
            ]
        ];

        if (!isset($response["query"])) {
            $response["query"] = $query;
        }

        return $response;
    }

    public static function outputGenericError($extraMsg = '', $query = NULL, $devMessage = NULL)
    {
        return EndpointResponse::outputSpecificErrorMessage('500', 'A server error occurred ' . $extraMsg, $query, $devMessage);
    }
}

?>