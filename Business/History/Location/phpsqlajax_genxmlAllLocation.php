<?php
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("../../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
session_start();
$imei = $_SESSION["imei"];
$imei = encrypt($imei, $key);
function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

// Opens a connection to a MySQL server
$connection=mysql_connect (localhost, $username, $password);
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
// Gets data from URL parameters

// Select all the rows in the markers table
$systemDate = date("Y-m-d H:i:s");  
$query = "";
$time ="";
if (isset($_GET['time'])){
	$time  = $_GET['time'];
	$systemDate = date("Y-m-d");
	if($_GET['time']!=""){
	$query = "select id, imei, TimeStamp, Latitude, Longitude, Speed from ". $tablePosition ." where DATE(TimeStamp) = '$time' and imei = '$imei' order by id";
	}
	else if($_GET['time']==""){
		$query = "select id, imei, TimeStamp, Latitude, Longitude, Speed from ". $tablePosition ." where Date(Timestamp)= '$systemDate' and imei = '$imei'  order by id";
		}
}
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<locations>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<location ';
  echo 'id="' . $row['id'] . '" ';
  echo 'imei="' . decrypt($row['imei'], $key) . '" ';
  echo 'TimeStamp="' . $row['TimeStamp'] . '" ';
  echo 'Latitude="' . decrypt($row['Latitude'], $key) . '" ';
  echo 'Longitude="' . decrypt($row['Longitude'], $key) . '" ';
  echo 'Speed="' . decrypt($row['Speed'], $key) . '" ';
  echo '/>';
}
// End XML file
echo '</locations>';

?>
