<?php  
require("Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("Common/EncryptDecrypt/Encrypy_Decrypt.php");
//connect to the database 
$connect=mysql_connect (localhost, $username, $password);
mysql_select_db($database,$connect); 

// array for JSON response
$response = array();
$imeiOriginal = '358490041283939';
			$fileName = 'position2.csv';
			//get the csv file
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				
				list($id, $imeiCSV, $timestamp, $tag, $type, $accuracy, $latitude, $longitude, $altitude, $speed, $bearing, $distFromNetLocation, $locationTime, $debugInfo) = $data;
				
				$tag = encrypt($tag, $key);	
				$type = encrypt($type, $key);
				$accuracy = encrypt($accuracy, $key);
				$latitude = encrypt($latitude, $key);
				$longitude = encrypt($longitude, $key);
				$altitude = encrypt($altitude, $key);
				$speed = encrypt($speed, $key);
				$bearing = encrypt($bearing, $key);
				$distFromNetLocation = encrypt($distFromNetLocation, $key);
				$locationTime = encrypt($locationTime, $key);
				$debugInfo = encrypt($debugInfo, $key);		
				$imei = encrypt($imeiOriginal, $key);
				
				mysql_query("INSERT INTO " . $tablePosition . " (imei, Timestamp, Tag, Type, Accuracy, Latitude, Longitude, 
												Altitude, Speed, Bearing, DistFromNetLocation, LocationTime, DebugInfo) 
							VALUES('$imei', '$timestamp', '$tag', '$type', '$accuracy', '$latitude', '$longitude', 
									'$altitude', '$speed', '$bearing', '$distFromNetLocation', '$locationTime', '$debugInfo')");
					if ($result) {
						// successfully inserted into database
						$response["success"] = 1;
						$response["message"] = "A row successfully created.";
						// echoing JSON response
						echo json_encode($response);
					} else {
						// failed to insert row
						$response["success"] = 0;
						$response["message"] = "Oops! An error occurred.";
						
						// echoing JSON response
						echo json_encode($response);
					}
				}
			fclose($handle);


?>