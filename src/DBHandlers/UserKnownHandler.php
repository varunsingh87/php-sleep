<?php 

namespace VarunS\BorumSleep\DBHandlers;

use VarunS\BorumSleep\SimpleRest;

class UserKnownHandler extends DBHandler {
    /**
     * The result of the MySQL query to get the user with the passed in api key
     * @var mysqli_result 
     */
    protected $user;

    /**
     * The associative array on the user or lack thereof who is querying the notes
     * @var Array
     */
    protected $userArray;

    /**
     * The id of the user
     * @var int
     */
    protected $userId;
    
    /**
     * @param string $userApiKey The api key of the user requesting the jottings
     */
    function __construct($userApiKey, $dbUsername, $dbPassword, $dbHost, $dbName) {
        parent::__construct($dbUsername, $dbPassword, $dbHost, $dbName);

        // Exit early if the API key is invalid
        $this->user = $this->getUserFromApiKey($userApiKey);
        $this->handleInvalidApiKey($this->user);
        $this->userArray = mysqli_fetch_array($this->user, MYSQLI_BOTH);
        $this->userId = $this->userArray['id'];
    }

    /** 
     * Helper logic that exits the script if the user is invalid
     * @param mysqli_result $user The result of the query that selects the user with the passed in api key
     * @return void 
    */
    protected function handleInvalidApiKey($user) : void {
        if (mysqli_num_rows($user) == 0) {
            SimpleRest::setHttpHeaders(404);
            echo json_encode([
                "statusCode" => 404,
                "error" => [
                    "message" => "The user does not exist"
                ]
            ]);
            exit();
        }
    }
}

?>