<?php 

namespace VarunS\BorumSleep;

/**
 * Utility class with helper methods
 */
class Helpers {
	/**
	 * Gets the usable value from the authorization header
	 * @param string $authorizationHeader The full string
	 * @return string The value after the text "Basic "
	 */
	public static function parseAuthorizationHeader($authorizationHeader) : String {
		return substr($authorizationHeader, strlen("Basic "));
	}
}

?>