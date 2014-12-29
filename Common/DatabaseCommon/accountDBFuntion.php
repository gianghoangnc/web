<?php
require("phpsqlajax_dbinfo.php");
require("../EncryptDecrypt/Encrypy_Decrypt.php");
session_start();
$imei = $_SESSION["imei"];
$imei = encrypt($imei, $key);
// Gets data from URL parameters
// Opens a connection to a MySQL server
$connection = mysql_connect ($localhost, $username, $password);
mysql_query("SET character_set_client=utf8", $connection);
mysql_query("SET character_set_connection=utf8", $connection);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
mysql_query('SET NAMES utf8');
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}
$timezone = date_default_timezone_get();
$systemDate = date("Y-m-d H:i:s");  

if($_POST['action'] == 'update'){
	$id  = $_POST['id'];
	$role  = $_POST['role'];
	$imei  = $_POST['imei'];
	$phone_number  = $_POST['phone_number'];
	$email  = $_POST['email'];
	
	$imei = encrypt($imei, $key);
	$phone_number = encrypt($phone_number, $key);
	$email = encrypt($email, $key);
	
	$query6 = "select * from account where id='$id'";
 	$result6 = mysql_query($query6);
	if (!$result6) {
 		 die('Invalid query: ' . mysql_error());
	}
 $row = @mysql_fetch_assoc($result6);
 //Check ton tai usernameRegister
 $query7 = "Select * from (SELECT * FROM account WHERE imei!='".$row["imei"]."') as t where imei='".$imei."'";
 $query8 = "Select * from (SELECT * FROM account WHERE email!='".$row["email"]."') as t where email='".$email."'";
 $query9 = "Select * from (SELECT * FROM account WHERE phone_number!='".$row["phone_number"]."') as t where phone_number='".$phone_number."'";
  //Kiem tra gia tri co ton tai trong DB
 $checkImei = mysql_query($query7, $connection);
 $checkEmail = mysql_query($query8, $connection);
 $checkMoblie = mysql_query($query9, $connection);
  $check = 0;
 if (mysql_num_rows($checkImei) != 0) { //Trung so imei
 	$check = 1;
   	echo "<script>window.location = '../../admin.php'
				alert('Imei nay da duoc dang ky giam sat roi. Hay kiem tra lai');
		</script>";

 } else if (mysql_num_rows($checkEmail) != 0){  //Trung dia chi email
 	$check = 1;
	echo "<script>window.location = '../../admin.php'
				alert('email nay da duoc dang ky roi. Vui long dang ky Email khac');
		</script>";
 } else if (mysql_num_rows($checkMoblie) != 0){  //Trung Mobile
 	$check = 1;
		echo "<script>window.location = '../../admin.php'
				alert('So Dien thoai nay da duoc dang ky roi. Vui long su dung so dien thoai khac');
		</script>";
 }
	// Update row with user data
 if($check == 0){  
    //Prepare query to insert to DB
 	$query10 = "update " . $tableAccount ." set role = '$role', imei = '$imei', phone_number = '$phone_number', email = '$email' where id = '$id'";
	$result10 = mysql_query($query10, $connection);
  //Insert to DB
  if(!mysql_query($query10,$connection)){
	echo "<script>window.location = '../../admin.php'
			alert('Error');
		</script>";
  }	
  else{
	  	echo "<script>window.location = '../../admin.php'
				alert('UPDATED');
		</script>";
  }
	
 }
}
else if($_POST['action'] == 'delete'){
	$id  = $_POST['id'];
	
	// Delete row with user data
	$query11 = "delete from " . $tableAccount ." where id = '$id'";
	$result11 = mysql_query($query11, $connection);

	if (!mysql_query($query11,$connection)) {
	  	echo "<script>window.location = '../../admin.php'
			alert('Error');
		</script>";
	}
	else{
	echo "<script>window.location = '../../admin.php'
				alert('DELETED');
		</script>";
	}
}
else if($_POST['action'] == 'resetPassword'){
	$id  = $_POST['id'];
	// Delete row with user data
	$string = "12345678";
	$newPassword = md5($string);
	$query12 = "update " . $tableAccount ." set password = '$newPassword' where id = '$id'";
	$result12 = mysql_query($query12, $connection);

	if (!mysql_query($query12,$connection)) {
	  	echo "<script>window.location = '../../admin.php'
			alert('Error');
		</script>";
	}
	else{
	echo "<script>window.location = '../../admin.php'
				alert('Reset Password');
		</script>";
	}
}
?>
