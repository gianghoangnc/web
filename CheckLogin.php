<?php

/**
 * @author coi_xink
 * @copyright 2012
 */
require("Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("Common/EncryptDecrypt/Encrypy_Decrypt.php");
$con = mysql_connect(localhost, $username, $password);
 if(!$con) {
    die('Could not conncet: '.mysql_error());
 } 
 $db_selected = mysql_select_db($database, $con);
  // C�c gi� tr? du?c luu trong bi?n $_POST
  // Ki?m tra n?u du?c post
  if($_POST) {
      // �ua d? li?u v�o c�c bi?n
		$name 		= $_POST['name']; 
		$name = encrypt($name, $key);
		$pwd 		= md5($_POST['pwd']); 
		
		$name=strip_tags(mysql_real_escape_string($name)); 

      // Ph?n x? l� c?a c�c b?n..
        $sql = "SELECT * FROM " . $tableAccount . " WHERE user_name='$name' AND password ='$pwd'";
		$result = mysql_query($sql) or die(mysql_error());
		$no_of_rows = mysql_num_rows($result);
		
		if ($no_of_rows > 0)//Th�nh c�ng     
		{		
			$row = @mysql_fetch_assoc($result);
			session_start();
			$_SESSION["myname"] = decrypt($row['user_name'], $key); // Luu name v�o session
			$_SESSION["imei"] = decrypt($row['imei'], $key); // Luu imei v�o session
			echo '<p class="success"><p>Chuc mung ban <span style="color:blue" >'.$_SESSION["myname"].'<p></span> da dang nhap thanh cong! <br> 
				<a href="Business/Login/LogOut.php">Log out</a> !</p>';
			$role = $row['role'];
			if($role == "1"){
				echo "<script>window.location = 'admin.php'</script>";
				}
				else if($role == "2"){
			  echo "<script>window.location = 'showHistory.php'</script>";
			  }
			  else{
				 echo  "<script>window.location = 'index.php'
				  alert('Your account has been locked. Please contact Admin!');
				  </script>";

			}
		}
		else //Th?t b?i 
				{echo '<p class="success">Username hoac password khong dung !</p>'; 
				echo "<script>window.location = 'index.php'
				alert('Login Failed');
				</script>";
				}
  }
  else{
	echo '<p>Please enter username and password</p>';
  }

?>