<?php

namespace VarunS\BorumSleep\DBHandlers;

function connectToDB() {
    // Connecting to mysql database
    $dbc = mysqli_connect($_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_HOST"], $_ENV["DB_NAME"]);    
 
    // Check for database connection error
    if (mysqli_connect_errno()) {
        echo "Failed to connect to server";
    }
 
    return $dbc; // returning connection resource
}

?>