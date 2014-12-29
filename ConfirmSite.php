<?php

/**
 * @author coi_xink
 * @copyright 2012
 */
 //Declare variable
 require("Common/EncryptDecrypt/Encrypy_Decrypt.php");
 
 $usernameRegister = $_POST["username"];
 $pwd = md5($_POST["password"]);
 $imei = $_POST["imei"];
 $mobile = $_POST["mobi"];
 $email = $_POST["email"];
 
 $usernameRegister = encrypt($usernameRegister, $key);
 $imei = encrypt($imei, $key);
 $mobile = encrypt($mobile, $key);
 $email = encrypt($email, $key);
 
 //Init connection
require("Common/DatabaseCommon/phpsqlajax_dbinfo.php");
 $con = mysql_connect(localhost, $username, $password);
 if(!$con) {
    die('Could not conncet: '.mysql_error());
 } 
$db_selected = mysql_select_db($database, $con);
 //Check ton tai usernameRegister
 $query1 = "SELECT * FROM ".$tableAccount." WHERE user_name='$usernameRegister'";
 $query2 = "SELECT * FROM ".$tableAccount." WHERE imei='$imei'";
 $query3 = "SELECT * FROM ".$tableAccount." WHERE email='$email'";
 $query4 = "SELECT * FROM ".$tableAccount." WHERE phone_number='$mobile'";
 
 //Kiem tra gia tri co ton tai trong DB
 $checkName = mysql_query($query1);
 $checkImei = mysql_query($query2);
 $checkEmail = mysql_query($query3);
 $checkMoblie = mysql_query($query4);
 $check = 0;
 if (mysql_num_rows($checkName)!=0)//Trung usernameRegister
 {		
 $check = 1;
   echo '<div id="container">
	<p id="confirm">Ten cua ban da duoc dang ky roi. Vui long thu ten khac</p>
	<a href="index.php">Login</a>
    </div>'; 
 }
 else 
 if (mysql_num_rows($checkImei)!=0) { //Trung so imei
 $check = 1;
    echo '<div id="container">
	<p id="confirm">Imei thoai nay da duoc dang ky giam sat roi. Hay kiem tra lai
	<br>
		<a href="RegisterSite.php">Resgister</a>
		</p>
    </div>';
 } else
 if (mysql_num_rows($checkEmail) != 0){  //Trung dia chi email
 $check = 1;
    echo '<div id="container">
	<p id="confirm">Tai khoan email nay da duoc dang ky roi. Vui long dang ky tai khoan khac
	<br>
	<a href="RegisterSite.php">Resgister</a>
	</p>
    </div>';
 }else
 if (mysql_num_rows($checkMoblie) != 0){  //Trung dia chi Moblie
 $check = 1;
    echo '<div id="container">
	<p id="confirm">So dien thoai nay da duoc dang ky roi. Vui long dang ky so dien thoai khac khac
	<br>
	<a href="RegisterSite.php">Resgister</a>
	</p>
    </div>';
 } 
 
 
 if($check  == 0){  
    //Prepare query to insert to DB
  $query = "INSERT INTO " . $tableAccount . " (user_name , password , role , imei , phone_number , email) " .
           "VALUES ('". $usernameRegister . "' , '" . $pwd . "' , 0 , '" . $imei . "' , '" . $mobile . "' , '" . $email . "' )";
		   $time_duration = 5;
  $query2 = "INSERT INTO " . $tableParameters . " (imei, time_duration) VALUES ('". $imei ."', '".$time_duration."')";
  mysql_query($query2,$con);																		
  //Insert to DB
  if(!mysql_query($query,$con)){
    die('Error: ' . mysql_error());
  }	
	else{
	echo '<div id="container">
	<p id="confirm">Registration successful !<br>
	<a href="index.php">Login</a>
	</p>
    </div>';	
	}
 }
 
 mysql_close($con);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>REGISTRATION</title>
	<link type="text/css" href="Common/CSS/style.css" rel="stylesheet">
</head>
<body>
</body>
</html>