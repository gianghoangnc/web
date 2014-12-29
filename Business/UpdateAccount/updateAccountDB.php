<?php
require("../../Common/EncryptDecrypt/Encrypy_Decrypt.php");
 session_start();
 
 $usernameSession =	$_SESSION['myname'];
 $imeiSession = $_SESSION['imei'];
 
 $usernameSession = encrypt($usernameSession, $key);
 $imeiSession = encrypt($imeiSession, $key);
 
 //Init connection
require("../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
 $con = mysql_connect(localhost, $username, $password);
 if(!$con) {
    die('Could not conncet: '.mysql_error());
 } 
$db_selected = mysql_select_db($database, $con);



if($_POST['action'] == 'update'){
	
 $usernameRegister = $_POST["username"];
 $imei = $_POST["imei"];
 $mobile = $_POST["mobi"];
 $email = $_POST["email"];
 
 $usernameRegister = encrypt($usernameRegister, $key);
 $imei = encrypt($imei, $key);
 $mobile = encrypt($mobile, $key);
 $email = encrypt($email, $key);
 
 $query1 = "select * from account where user_name='".$usernameRegister."'";
 $result1 = mysql_query($query1);
if (!$result1) {
  die('Invalid query: ' . mysql_error());
}

 $row = @mysql_fetch_assoc($result1);
 //Check ton tai usernameRegister
 $query2 = "Select * from (SELECT * FROM account WHERE imei!='".$row["imei"]."') as t where imei='".$imei."'";
 $query3 = "Select * from (SELECT * FROM account WHERE email!='".$row["email"]."') as t where email='".$email."'";
 $query4 = "Select * from (SELECT * FROM account WHERE phone_number!='".$row["phone_number"]."') as t where phone_number='".$mobile."'";
 //Kiem tra gia tri co ton tai trong DB
 $checkImei = mysql_query($query2);
 $checkEmail = mysql_query($query3);
 $checkMoblie = mysql_query($query4);
 $check = 0;
 if (mysql_num_rows($checkImei) != 0) { //Trung so imei
 	$check = 1;
		echo  "<script>window.location = '../../updateAccount.php'
					alert('The Imei number already resgitered for tracking. Please use another Imei number. Thank!!!');
				  </script>";
 } else if (mysql_num_rows($checkEmail) != 0){  //Trung dia chi email
 	$check = 1;
		echo  "<script>window.location = '../../updateAccount.php'
					alert('The Email address already resgitered. Please use another Email address. Thank!!!');
				  </script>";
 } else if (mysql_num_rows($checkMoblie) != 0){  //Trung Mobile
 	$check = 1;
		echo  "<script>window.location = '../../updateAccount.php'
					alert('The mobile number already resgitered. Please use another mobile number. Thank!!!');
				  </script>";
 } 
 if($check == 0){  
    //Prepare query to insert to DB
  $query5 = "UPDATE " . $tableAccount . " set imei='". $imei ."', phone_number='" . $mobile . "', email='" .  $email . "' where user_name='" . $usernameRegister . "'";
  //Insert to DB
  if(!mysql_query($query5,$con)){
    die('Error: ' . mysql_error());
  }	
  else{
	  session_start();
	  $_SESSION["imei"] = $_POST["imei"];
	  
	echo  "<script>window.location = '../../updateAccount.php'
					alert('Update successful !!!');
				  </script>";
  }
	
 }
}
if($_POST['action'] == 'Delete'){
	$date = $_POST['demo1'];
	$checkBox1 = $_POST['CheckboxGroup1'];
	$checkBox2 = $_POST['CheckboxGroup2'];
	$checkBox3 = $_POST['CheckboxGroup3'];
	$sql = "select * from ".$tableAccount." where user_name='$usernameSession'"; 
	$result2 = mysql_query($sql) or die(mysql_error());
	$row = @mysql_fetch_assoc($result2);
	$imei = $row['imei'];
	if($checkBox1=='Tracking'){
		$query6 = "DELETE FROM " . $tablePosition ." where Date(Timestamp) = '" . $date . "' and imei = '" .$imei. "'";
		  if(!mysql_query($query6,$con)){
			die('Error: ' . mysql_error());
		  }	
		  else{
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Delete successful !!');
				  </script>";
		  }			
 	}
	 if($checkBox2=='SMS'){
		$query7 = "DELETE FROM " . $tableSms ." where Date(time) = '" . $date . "' and imei = '" .$imei. "'";
		  if(!mysql_query($query7,$con)){
			die('Error: ' . mysql_error());
		  }	
		  else{
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Delete successful !!');
				  </script>";
		  }			
 	}
	 if($checkBox3=='CallLog'){
		$query8 = "DELETE FROM " . $tableCallLog ." where Date(time) = '" . $date . "' and imei = '" .$imei. "'";
		  if(!mysql_query($query8,$con)){
			die('Error: ' . mysql_error());
			echo "asdasd";
		  }	
		  else{
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Delete successful !!');
				  </script>";
		  }			
 	}
	else {
			  echo  "<script>window.location = '../../updateAccount.php'
					alert('Please select at least one option !!');
				  </script>";
	}
}

if($_POST['action'] == 'Backup'){
	$date = $_POST['demo1'];
	$checkBox1 = $_POST['CheckboxGroup1'];
	$checkBox2 = $_POST['CheckboxGroup2'];
	$checkBox3 = $_POST['CheckboxGroup3'];
	$sql = "select * from ".$tableAccount." where user_name='$usernameSession'"; 
	$result2 = mysql_query($sql) or die(mysql_error());
	$row = @mysql_fetch_assoc($result2);
	$imei = $row['imei'];
	if($checkBox1=='Tracking'){
		$query = "select * from " . $tablePosition . " where Date(Timestamp)='".$date."' and imei = '".$imei."' order by id";
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}
		$filename = "Tracking_data_" . $date . ".xls";
		$no_of_rows = mysql_num_rows($result);
		if($no_of_rows==0){
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Have no data for this day !!');
				  </script>";
		}
		else{
		$line1="ID\tImei\tTimestamp\tTag\tType\tAccuracy\tLatitude\tLongitude\tAltitude\tSpeed\tBearing\tDistFromNetLocation\tLocationTime\tDebugInfo\t";
		$data="$line1\n";
		while ($row = @mysql_fetch_assoc($result)){
			$imei = decrypt($row['imei'], $key);
			$Timestamp = $row['Timestamp'];
			$Tag = decrypt($row['Tag'], $key);
			$Type = decrypt($row['Type'], $key);
			$Accuracy = decrypt($row['Accuracy'], $key);
			$Latitude = decrypt($row['Latitude'], $key);
			$Longitude = decrypt($row['Longitude'], $key);
			$Altitude = decrypt($row['Altitude'], $key);
			$Speed = decrypt($row['Speed'], $key);
			$Bearing = decrypt($row['Bearing'], $key);
			$DistFromNetLocation = decrypt($row['DistFromNetLocation'], $key);
			$LocationTime = decrypt($row['LocationTime'], $key);
			$DebugInfo = decrypt($row['DebugInfo'], $key);
			
			$line2=$row['id']."\t".$imei."\t".$Timestamp."\t".$Tag."\t".$Type."\t".$Accuracy."\t".$Latitude."\t".$Longitude."\t".$Altitude."\t".$Speed."\t".$Bearing."\t".$DistFromNetLocation."\t".$LocationTime."\t".$DebugInfo."\t";
			
			$data=$data."\n".$line2;
		} 
			downloadData2($data,$filename);	
		}	
 	}
	if($checkBox2=='SMS'){
	$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, content from " . $tableSms . " where Date(time)='".$date."' and imei = '".$imei."' order by id";
	$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		  echo "asdas";
		}
		$filename = "SMS_data_" . $date . ".xls";
		$no_of_rows = mysql_num_rows($result);
		if($no_of_rows==0){
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Have no data for this day !!');
				  </script>";
		}
		else{
			$line1="ID\tImei\tType\tPhoneNumber\tTime\tContent\t";
			$data="$line1\n";
			while ($row = @mysql_fetch_assoc($result)){
				$imei = decrypt($row['imei'], $key);
				$Type = decrypt($row['type'], $key);
				$phone_number = decrypt($row['phone_number'], $key);
				$Time = $row['time'];
				$content = decrypt($row['content'], $key);
				
				$line2=$row['id']."\t".$imei."\t".$Type."\t".$phone_number."\t".$Time."\t".$content."\t";
				
				$data=$data."\n".$line2;
			} 
				downloadData2($data,$filename);		
		}	
 	}
	if($checkBox3=='CallLog'){
		$query = "select id, imei, type, phone_number, time, Date(time) as dateTime, duration from ". $tableCallLog ." where Date(time)='".$date."' and imei = '".$imei."' order by id";	
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}
		$filename = "Call_Log_data_" . $date . ".xls";
		$no_of_rows = mysql_num_rows($result);
		if($no_of_rows==0){
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Have no data for this day !!');
				  </script>";
		}
		else{
			$line1="ID\tImei\tType\tPhone Number\tTime\tDuration\t";
			$data="$line1\n";
			while ($row = @mysql_fetch_assoc($result)){
				$imei = decrypt($row['imei'], $key);
				$Type = decrypt($row['type'], $key);
				$phone_number = decrypt($row['phone_number'], $key);
				$Time = $row['time'];
				$duration = decrypt($row['duration'], $key);
				
				$line2=$row['id']."\t".$imei."\t".$Type."\t".$phone_number."\t".$Time."\t".$duration."\t\t";
				
				$data=$data."\n".$line2;
			} 
				downloadData2($data,$filename);	
		}
 	}
		else {
			  echo  "<script>window.location = '../../updateAccount.php'
					alert('Please select at least one option !!');
				  </script>";
	}
}

if($_POST['action'] == 'ChangePassword'){

 $passwordOld = md5($_POST["passwordOld"]);
 $passwordNew = md5($_POST["passwordNew"]);
 $query9 = "select * from ".$tableAccount." where user_name='$usernameSession' and password='$passwordOld'";
 $result3 = mysql_query($query9);
if (!$result3) {
  die('Invalid query: ' . mysql_error());
}
 $row2 = @mysql_fetch_assoc($result3);
  if (mysql_num_rows($result3) != 0) {
	 $query10 = "UPDATE " . $tableAccount . " set password='". $passwordNew ."' where user_name='" . $usernameSession ."'" ;
	 $result4 = mysql_query($query10);
	 if (!$result4) {
 		 die('Invalid query: ' . mysql_error());
		}
		else {
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Successful !!');
				  </script>";
		}
}
else {
		  echo  "<script>window.location = '../../updateAccount.php'
					alert('Wrong Password!!');
				  </script>";
}
}


function downloadData2(&$data, &$filename){
header("Content-type: application/x-msdownload"); 
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
print "$header\n$data"; 
exit;
} 
 mysql_close($con);
?>

