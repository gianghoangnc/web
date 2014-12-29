<?php
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
$imei = $_POST['imei'];
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
  // table 
    $query = "Select * from " . $tableParameters . " where imei = '$imei'";
	$result = mysql_query($query);
	// lay data tung dong va mahoa anh duoi dang string
    while($parameter = mysql_fetch_assoc($result)) {
        $array = $parameter;
        $array['parameter'] = base64_encode($parameter['parameter']);
        $output[] = $array;
    }
    // ma hoa tat ca object duoi dang json
    echo json_encode($output);
    mysql_close();
?>