<?php

namespace VarunS\PHPSleep\DBHandlers;

class Config {
    function __construct($user, $pass, $host, $name) {
        $this->dbUsername = $user;
        $this->dbPassword = $pass;
        $this->dbHost = $host;
        $this->dbName = $name;
    }

    public static function createConfigFromEnv() {
        return new Config($_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_HOST"], $_ENV["DB_NAME"]);
    }
    
    function connectToDB() {
        // Connecting to mysql database
        $dbc = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);    
    
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to server";
        }
    
        return $dbc; // returning connection resource
    }
}

?>