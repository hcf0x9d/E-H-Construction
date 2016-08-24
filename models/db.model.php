<?php

# db.inc.php
# Version 1.0
#
# Created by Jason Fukura
# jason@jasonfukura.com
#
# Last Modified:

# Script purpose:
# 	- Database Connect

# Database -> ppAdmin
# Table -> ppAdmin_Event (event information)
# 			- EventID (Integer) (PK)
# 			- EventName (String)
# 			- EventMeta (Object)
# 				- Location
# 				- EventDate
# 				- ??
# 			- ExpiryDate
#
# Table -> ppAdmin_Gallery (gallery information)
# 			- GalleryID (Integer) (PK)
# 			- AccessCode (VarChar)
#
# Table -> ppAdmin_GalleryToEvent (link table)
# 			- LinkID (Integer) (PK)
# 			- fk_EventID (Integer)
# 			- fk_GalleryID (Integer)
#
# FUTURE OPTIONS
# - User Registration
# - Hook in to APIs for printing
#


// Connect to database
try {
	$db = new PDO("mysql:host=".HOST.";dbname=".NAME.";charset=utf8", "".USER."", "".PASS."");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// PDO fetch docs: http://php.net/manual/en/pdostatement.fetch.php
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo $e->getMessage();
}

// Simple function to handle PDO prepared statements
function sql($db, $q, $params, $return) {
	// Prepare statement
	$stmt = $db->prepare($q);

	// Execute statement
	$stmt->execute($params);

	// Decide whether to return the rows themselves, or just count the rows
	if ($return == "rows") {
    	return $stmt->fetchAll();
  	}
  	elseif ($return == "count") {
    	return $stmt->rowCount();
  	}
}

/* EXAMPLE USAGE

// With SELECT
// Call function
$rows = sql($db, "SELECT * FROM table WHERE id = ?", array($id), "rows");

// Get results
foreach($rows as $row) {
    echo $row['field1'].' '.$row['field2']; //etc...
}

// With INSERT
// Call function
sql($db, "INSERT INTO table (field1, field2, field3) VALUES (?, ?, ?)", array($id, $name, $pass));

// With UPDATE
// Call function
sql($db, "UPDATE table SET name = ? WHERE id = ?", array($name, $id));

// With DELETE
// Call function
sql($db, "DELETE FROM table WHERE id = ?", array($id));
*/
