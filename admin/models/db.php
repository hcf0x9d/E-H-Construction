<?php

$dbServername = "localhost";
$dbUsername = "ehconstr_tech";
$dbPassword = "dT8Cu6VvW?m?";
$database = "ehconstr_ehconstruction";

function getConnection($port = false) {
    global $dbServername, $dbUsername, $dbPassword, $database, $port;

    $mysqli = new mysqli( $dbServername, $dbUsername, $dbPassword, $database);
    
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL database " . $database . ": " . $mysqli->connect_error;
	}
    return $mysqli;
}

?>