<?php  
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
//connect to the database 
$connect=mysql_connect (localhost, $username, $password);
mysql_select_db($database,$connect); 

// array for JSON response
		$response = array();
			$fileName = "000000000000000-tracking.csv";
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				list($id, $timestamp, $tag, $type, $accuracy, $latitude, $longitude, $altitude, $speed, $bearing, $distFromNetLocation, $locationTime, $debugInfo) = $data;
				mysql_query("INSERT INTO " . $tablePosition . " (imei, Timestamp, Tag, Type, Accuracy, Latitude, Longitude, 
												Altitude, Speed, Bearing, DistFromNetLocation, LocationTime, DebugInfo) 
							VALUES('$imei', '$timestamp', '$tag', '$type', '$accuracy', '$latitude', '$longitude', 
									'$altitude', '$speed', '$bearing', '$distFromNetLocation', '$locationTime', '$debugInfo')");
					if ($result) {
						// successfully inserted into database
						$response["success"] = 1;
						$response["message"] = "A row successfully created.";

						// echoing JSON response
						echo $response;
					} else {
						// failed to insert row
						$response["success"] = 0;
						$response["message"] = "Oops! An error occurred.";
						
						// echoing JSON response
						echo $response;
					}
				}
			fclose($handle);	
	
?>