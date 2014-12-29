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

$query = "";
$time ="";
if (isset($_GET['time'])){
	$systemDate = date("Y-m-d");
	$mobileNumber = $_GET['mobileNumber'];
	$mobileNumber = encrypt($mobileNumber, $key);
	$time  = $_GET['time'];
	if($_GET['time']!="" && $_GET['mobileNumber']!=""){
	$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, duration from ". $tableCallLog ." where DATE(time) = '$time' and imei = '$imei' and phone_number = '$mobileNumber' order by id";
	}
	else if($_GET['time']=="" && $_GET['mobileNumber']==""){
		$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, duration from ". $tableCallLog ." where Date(time)= '$systemDate' and imei = '$imei' order by id";
		}
	else if($_GET['time']=="" && $_GET['mobileNumber']!=""){
		$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, duration from ". $tableCallLog ." where Date(time)= '$systemDate' and imei = '$imei' and phone_number = '$mobileNumber' order by id";
		}
	else if($_GET['time']!="" && $_GET['mobileNumber']==""){
		$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, duration from ". $tableCallLog ." where Date(time)= '$time' and imei = '$imei'  order by id";
		}		
}

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<calllogE>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<calllog ';
  echo 'id="' . $row['id'] . '" ';
  echo 'imei="' . decrypt($row['imei'], $key) . '" ';
  echo 'type="' . decrypt($row['type'], $key) . '" ';
  echo 'phone_number="' . decrypt($row['phone_number'], $key) . '" ';
  echo 'time="' . $row['time'] . '" ';
  echo 'dateTime="' . $row['dateTime'] . '" ';
  echo 'duration="' . decrypt($row['duration'], $key) . '" ';
  echo '/>';
}
// End XML file
echo '</calllogE>';

?>
