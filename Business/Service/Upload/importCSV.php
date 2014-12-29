<?php  
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("../../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
//connect to the database 
$connect=mysql_connect (localhost, $username, $password);
mysql_select_db($database,$connect); 

// array for JSON response
$response = array();
if (isset($_POST['header'])) {
$imei = $_POST['imei'];
	if($_POST['header']=='tracking'){
			$fileName = 'tracking.csv';
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				
				list($id, $imei2, $timestamp, $tag, $type, $accuracy, $latitude, $longitude, $altitude, $speed, $bearing, $distFromNetLocation, $locationTime, $debugInfo) = $data;
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
				$imei2 = encrypt($imei2, $key);
				
				mysql_query("INSERT INTO " . $tablePosition . " (imei, Timestamp, Tag, Type, Accuracy, Latitude, Longitude, 
												Altitude, Speed, Bearing, DistFromNetLocation, LocationTime, DebugInfo) 
							VALUES('$imei2', '$timestamp', '$tag', '$type', '$accuracy', '$latitude', '$longitude', 
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
			
	}
	
	else if($_POST['header']=='sms'){
			$fileName = 'sms2.csv';
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				list($id, $imei2, $type, $phone_number, $time, $content) = $data;
				$firstCharater = substr($phone_number,0,1);
				if($firstCharater=="+"){
				$anotherCharater = substr($phone_number,3);
					$formatNumber = "0".$anotherCharater;
				}
				else {$formatNumber=$phone_number;}
				$type = encrypt($type, $key);	
				$formatNumber = encrypt($formatNumber, $key);
				$content = encrypt($content, $key);		
				$imei2 = encrypt($imei2, $key);
				mysql_query("INSERT INTO " .$tableSms  . " (imei, type, phone_number, time, content) 
							VALUES('$imei2', '$type', '$formatNumber', '$time', '$content')");
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
			
	}
	
	else if($_POST['header']=='calllog'){
			$fileName = 'callLog.csv';
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				list($id, $imei2, $type, $phone_number, $time, $duration) = $data;
				$firstCharater = substr($phone_number,0,1);
				if($firstCharater=="+"){
				$anotherCharater = substr($phone_number,3);
					$formatNumber = "0".$anotherCharater;
				}
				else {$formatNumber=$phone_number;}
				$type = encrypt($type, $key);	
				$formatNumber = encrypt($formatNumber, $key);
				$duration = encrypt($duration, $key);		
				$imei2 = encrypt($imei2, $key);
				mysql_query("INSERT INTO " . $tableCallLog ." (imei, type, phone_number, time, duration) 
							VALUES('$imei2 ', '$type', '$formatNumber', '$time', '$duration')");
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
			
	}
	else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
}
?>