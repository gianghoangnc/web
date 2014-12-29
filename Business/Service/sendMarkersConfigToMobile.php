<?php
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
$imei = $_POST['imei'];
// Get imei from mobile

// Opens a connection to a MySQL server
$connection = mysql_connect (localhost, $username, $password);
mysql_query("SET character_set_results=utf8", $connection);
mb_language('uni');
mb_internal_encoding('UTF-8');
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
mysql_query("set names 'utf8'",$connection);

if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$dataConfig = array();
$query = "select name, radius, latitude, longitude from danger_area where imei = '". $imei ."'";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


// Iterate through the rows, printing XML nodes for each
while ($rowMarkers = @mysql_fetch_assoc($result)){
    $dataConfig[] = $rowMarkers;
}

echo json_encode($dataConfig);

?>
