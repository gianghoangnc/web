<?php
require("../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
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

// Select all the rows in the markers table
$query = "select id, imei, name, comment, radius, latitude, longitude, createdAt from " . $tableDangerArea ." where imei = '$imei'";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'id="' . $row['id'] . '" ';
  echo 'imei="' .decrypt($row['imei'], $key) . '" ';
  echo 'Name="' . decrypt($row['name'], $key) . '" ';
  echo 'Comment="' . decrypt($row['comment'], $key) . '" ';
  echo 'Radius="' . $row['radius']. '" ';
  echo 'Latitude="' .decrypt($row['latitude'], $key) . '" ';
  echo 'Longitude="' . decrypt($row['longitude'], $key) . '" ';
  echo 'createdAt="' . $row['createdAt'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>
