<?php 

namespace VarunS\BorumSleep\DBHandlers;

use function VarunS\BorumSleep\DBHandlers\connectToDB as connectToDB;

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 * @author Varun Singh
 */
class DBHandler {

    protected $conn;

    /**
     * Default super constructor for DBHandler
     * Connects to the database using the Configuration file
     */
    function __construct($dbUsername, $dbPassword, $dbHost, $dbName) {
        require __DIR__ . "/Config.php";
        $this->conn = connectToDB($dbUsername, $dbPassword, $dbHost, $dbName);
    }

    /**
     * Get the user with the given api key
     * @param string $userApiKey
     * @return mysqli_result The result of the MySQL SELECT query
     */
    protected function getUserFromApiKey($userApiKey) {
        return $this->executeQuery("SELECT * FROM users WHERE api_key = '" . $userApiKey . "'");
    }

    /**
     * Checks whether the API key is in the users table
     * AND whether it has a corresponding borum_user_id
     * @param String $apiKey user api key
     * @return boolean Whether the API Key is already in a row in the table of users in the database
     */
    protected function userExists($apiKey) {
        $userQuery = $this->getUserFromApiKey($apiKey);
        $num_rows = mysqli_num_rows($userQuery);
        return $num_rows > 0 && isset(mysqli_fetch_array($userQuery, MYSQLI_ASSOC)['borum_user_id']);
    }

    /**
     * Generates random Unique MD5 String for user API key
     */
    public static function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /**
     * Helper method to execute a MySQL query
     * @param string $query The SQL query string
     * @return mysqli_result|bool The result object of the query to the database
     */
    protected function executeQuery($query) {
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}

?>