<?php

require 'db.php';

// Get the inputs from the login form...
$usr = stripslashes($_POST['username']);
$pss = stripslashes($_POST['password']);

$sql = "SELECT * FROM tbl_users WHERE UserName='$usr' AND Password='$pss'";

$mysqli = getConnection();

$result = $mysqli->query($sql);
if ($result) {
    $count = $result->num_rows;
    
    if ($count == 1) {
        // If we have one result, start the session and return true
        session_start();
        $_SESSION['userName'] = $usr;
        
        echo '1';
    } else {
        // Return false...try again...
        echo '0';
    }
}

?>