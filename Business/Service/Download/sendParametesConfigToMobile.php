<?php
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("../../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
$imei = $_POST['imei'];
$imei = "358490041283939";
$imei = encrypt($imei, $key);
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

// Select all the rows in the parameters table
//$dataConfig = array();
$response = array();
$query = "select ".$tableParameters.".time_duration , ".$tableAccount.".imei, ".$tableAccount.".phone_number from ".$tableParameters." left join ".$tableAccount." on ".$tableAccount.".imei = ".$tableParameters.".imei where ".$tableAccount.".imei = '". $imei ."' ";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
    //$dataConfig[] = $rowparameters;
		$parameter = array();
        $parameter["time_duration"] = $row["time_duration"];
        $parameter["imei"] = decrypt($row["imei"], $key);
        $parameter["phone_number"] = decrypt($row["phone_number"], $key);
		
		// push single parameter into final response array
        array_push($response, $parameter);
}

//echo json_encode($dataConfig);
echo json_encode($response);
?>
