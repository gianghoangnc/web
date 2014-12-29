<?php
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("../../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
$imei = $_POST['imei'];
$imei = "358490041283939";
$imei = encrypt($imei, $key);
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
//$dataConfig = array();
$response = array();
$query = "select name, radius, latitude, longitude from " .$tableDangerArea." where imei = '". $imei ."'";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
    //$dataConfig[] = $rowMarkers;
	    $marker = array();
        $marker["id"] = $row["id"];
        $marker["imei"] = decrypt($row["imei"], $key);
        $marker["name"] = decrypt($row["name"], $key);
        $marker["comment"] = decrypt($row["comment"], $key);
        $marker["radius"] = $row["radius"];
        $marker["latitude"] = decrypt($row["latitude"], $key);
		$marker["longitude"] = decrypt($row["longitude"], $key);
		$marker["createdAt"] = $row["createdAt"];
		
		// push single marker into final response array
        array_push($response, $marker);
}
echo json_encode($response);
//echo json_encode($dataConfig);

?>
