<?php

// TODO: Setup a test database
// require '../models/config.model.php';
// require '../models/db.model.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'test' : getHomeSlides(); break;
    }
}


function getHomeSlides () {
	// $sql = "SELECT * FROM ...";

	// $rows = sql($db, $sql);

	// foreach($rows as $row) {
		// Return the values and json encode them....then return the json
		//
		$json = 'tis is a test';

		echo $json;
	// }
}
/* EXAMPLE USAGE

// With SELECT
// Call function
$rows = sql($db, "SELECT * FROM table WHERE id = ?", array($id), "rows");

// Get results
foreach($rows as $row) {
    echo $row['field1'].' '.$row['field2']; //etc...
}
*/

function test() {
	echo 'this is a test';
}