<?php
require("phpsqlajax_dbinfo.php");
session_start();
$imei = $_SESSION["imei"];
// Gets data from URL parameters
$name = $_GET['name'];
$comment = $_GET['comment'];
$radius = $_GET['radius'];
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];
$tag = $_GET['tag'];
// Opens a connection to a MySQL server
$connection = mysql_connect ($localhost, $username, $password);
mysql_query("SET character_set_client=utf8", $connection);
mysql_query("SET character_set_connection=utf8", $connection);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
mysql_query('SET NAMES utf8');
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
$timezone = date_default_timezone_get();
$systemDate = date("Y-m-d H:i:s");  

if($tag=="insert"){
	// Insert new row with user data
	$query = "insert into " . $tableDangerArea ." (imei, name, comment, radius, latitude, longitude, createdAt)
				values ('$imei', '$name', '$comment', '$radius', '$latitude', '$longitude', '$systemDate')";
	$result = mysql_query($query, $connection);

	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
	else{
	echo "1 record added";
	}
}
else if($tag=="update") {

	// Update row with user data
	$query2 = "update " . $tableDangerArea ." set name = '$name', comment = '$comment', radius = '$radius', createdAt = '$systemDate' where latitude = '$latitude ' and longitude = '$longitude' and imei = '$imei'";
	$result2 = mysql_query($query2, $connection);

	if (!$result2) {
	  die('Invalid query: ' . mysql_error());
	}
	else{
	echo "1 record update";
	}
}
else if($tag=="delete"){

	// Update row with user data
	$query3 = "delete " . $tableDangerArea . " where latitude = '$latitude ' and longitude = '$longitude' and imei = '$imei'";
	$result3 = mysql_query($query3, $connection);

	if (!$result3) {
	  die('Invalid query: ' . mysql_error());
	}
	else{
	echo "1 record delete";
	}
}
else if($tag=="updateParameter"){
	$timeDuration  = $_GET['timeDuration'];
	// Update row with user data
	$query5 = "update " . $tableParameters ." set time_duration = '$timeDuration' where imei = '$imei'";
	$result5 = mysql_query($query5, $connection);

	if (!$query5) {
	  die('Invalid query: ' . mysql_error());
	}
	else{
	echo "1 record updated";
	}
}
?>
