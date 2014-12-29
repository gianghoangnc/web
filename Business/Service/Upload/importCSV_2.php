<?php  
require("../../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
//connect to the database 
$connect=mysql_connect (localhost, $username, $password);
mysql_select_db($database,$connect); 

// array for JSON response
$response = array();
if (isset($_POST['header'])) {
$imei = $_POST['imei'];
	if($_POST['header']=='tracking'){
			$fileName = $_POST['filename'];
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
			$Pass = "giang";

				list($id, $timestamp, $tag, $type, $accuracy, $latitude, $longitude, $altitude, $speed, $bearing, $distFromNetLocation, $locationTime, $debugInfo) = $data;
				$tag1 = ENCRYPT_DECRYPT($tag);
				$type1 = ENCRYPT_DECRYPT($type);
				$accuracy1 = ENCRYPT_DECRYPT($accuracy);
				$latitude1 = ENCRYPT_DECRYPT($latitude);
				$longitude1 = ENCRYPT_DECRYPT($longitude);
				$altitude1 = ENCRYPT_DECRYPT($altitude);
				$speed1 = ENCRYPT_DECRYPT($speed);
				$bearing1 = ENCRYPT_DECRYPT($bearing);
				$distFromNetLocation1 = ENCRYPT_DECRYPT($distFromNetLocation);
				$locationTime1 = ENCRYPT_DECRYPT($locationTime);
				$debugInfo1 = ENCRYPT_DECRYPT($debugInfo);
				$imei1 = ENCRYPT_DECRYPT($imei);
				mysql_query("INSERT INTO position2 (imei, Timestamp, Tag, Type, Accuracy, Latitude, Longitude, 
												Altitude, Speed, Bearing, DistFromNetLocation, LocationTime, DebugInfo) 
							VALUES('$imei1', '$timestamp', '$tag1', '$type1', '$accuracy1', '$latitude1', '$longitude1', 
									'$altitude1', '$speed1', '$bearing1', '$distFromNetLocation1', '$locationTime1', '$debugInfo1')");
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
			$fileName = $_POST['filename'];
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				list($id, $type, $phone_number, $time, $content) = $data;
				mysql_query("INSERT INTO " .$tableSms  . " (imei, type, phone_number, time, content) 
							VALUES('$imei', '$type', '$phone_number', '$time', '$content')");
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
			unlink($fileName);
	}
	
	else if($_POST['header']=='calllog'){
			$fileName = $_POST['filename'];
			//get the csv file 
			$handle = fopen($fileName, 'r');
			while ($data= fgetcsv($handle, 100000, ","))
				{
				list($id, $type, $phone_number, $time, $duration) = $data;
				mysql_query("INSERT INTO " . $tableCallLog ." (imei, type, phone_number, time, duration) 
							VALUES('$imei', '$type', '$phone_number', '$time', '$duration')");
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
			unlink($fileName);
	}
	else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
}
    

FUNCTION ENCRYPT_DECRYPT($Str_Message) { 
//Function : encrypt/decrypt a string message v.1.0  without a known key 
//Author   : Aitor Solozabal Merino (spain) 
//Email    : aitor-3@euskalnet.net 
//Date     : 01-04-2005 
    $Len_Str_Message=STRLEN($Str_Message); 
    $Str_Encrypted_Message=""; 
    FOR ($Position = 0;$Position<$Len_Str_Message;$Position++){ 
        // long code of the function to explain the algoritm 
        //this function can be tailored by the programmer modifyng the formula 
        //to calculate the key to use for every character in the string. 
        $Key_To_Use = (($Len_Str_Message+$Position)+1); // (+5 or *3 or ^2) 
        //after that we need a module division because can´t be greater than 255 
        $Key_To_Use = (255+$Key_To_Use) % 255; 
        $Byte_To_Be_Encrypted = SUBSTR($Str_Message, $Position, 1); 
        $Ascii_Num_Byte_To_Encrypt = ORD($Byte_To_Be_Encrypted); 
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  //xor operation 
        $Encrypted_Byte = CHR($Xored_Byte); 
        $Str_Encrypted_Message .= $Encrypted_Byte; 
        
        //short code of  the function once explained 
        //$str_encrypted_message .= chr((ord(substr($str_message, $position, 1))) ^ ((255+(($len_str_message+$position)+1)) % 255)); 
    } 
    RETURN $Str_Encrypted_Message; 
} 
?>