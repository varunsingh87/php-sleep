<?php

namespace VarunS\BorumSleep\DBHandlers;

function connectToDB($dbUsername, $dbPassword, $dbHost, $dbName) {
    // Connecting to mysql database
    $dbc = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);    
 
    // Check for database connection error
    if (mysqli_connect_errno()) {
        echo "Failed to connect to server";
    }
 
    return $dbc; // returning connection resource
}

?>