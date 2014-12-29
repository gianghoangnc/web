<?php
session_start();
if(!isset($_SESSION['myname'])){
	echo "<script>window.location = '../../index2.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>REGISTRATION</title>
    </script>
<link href="../../Common/CSS/History.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="../../Common/CSS/style.css" rel="stylesheet">
	<script type="text/javascript" src="../../Common/JS/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../Common/JS/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../../Common/JS/localization/messages_vi.js"></script>
	<script type="text/javascript">
$(function() {

    $(".navigation ul li").hover(function() {
        $(this).addClass("hover");
    }, function() {
        $(this).removeClass("hover");
    });
    
    $(".navigation ul li").click(function() {
        $(".navigation ul li").removeClass("selected");		
        $(this).addClass("selected");
    });

});
		$(document).ready(function(){
			$("#contact").validate({
				errorElement: "span", 
				rules: {
					cpasswordNew: {
						equalTo: "#passwordNew" 
					},
					min_field: { min: 5 }, 
					max_field: { max : 10 },
					range_field: { range: [4,10] }, 
					rangelength_field: { rangelength: [4,10] }
				}
			});
		});
		$(document).ready(function(){
			$("#contact2").validate({
				errorElement: "span", 
				rules: {
					cpasswordNew: {
						equalTo: "#passwordNew" 
					},
					min_field: { min: 5 }, 
					max_field: { max : 10 },
					range_field: { range: [4,10] }, 
					rangelength_field: { rangelength: [4,10] }
				}
			});
		});
	</script>
</head>
<body>
<div class="center">
<div class="header"><!-- Header -->
        <div class="infoAcc">Hi <a href="AccInfo.html"><?php 
				echo "<b>".$_SESSION["myname"]."</b>";
				?>
                </a> | <a href="../../Business/Login/LogOut.php">Log Out</a></div>
        <div class="navigation">
          <ul>
            <li class="config"><a href="#"><span>Update Account</span></a></li>
            <li class="history selected"><a href="../History/Location/showHistory.php"><span>History</span></a></li>
            <li class="danger Area"><a href="../Marker/dangerArea.php"><span>Danger Area</span></a></li>
            <li class="contact"><a href="javascript:;"><span>Contact Us</span></a></li>
          </ul>
          <ul class="webSiteName">
             Mobile Tracking System
          </ul>
        </div>
    </div><!-- end Header -->
<div id="container">
<?php
require("../../Common/DatabaseCommon/phpsqlajax_dbinfo.php");
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
// Gets data from URL parameters

// Select all the rows in the markers table
session_start();
$user_name = $_SESSION['myname'];
$query = "select * from " . $tableAccount . " where user_name='" . $user_name . "'";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
else{
	$row = @mysql_fetch_assoc($result);
	echo '<form id="contact" method="post" action="../../Business/UpdateAccount/updateAccountDB.php" enctype="multipart/form-data" class="contact-form" >';
	echo '<center><h2>Mobile Tracking System Registration</h2></center>';
	echo '<table>';
	// Iterate through the rows, printing XML nodes for each
	  echo '<tr><td>Username <span class="rq"> * </span></td><td><input class="required" minlength="6" id="username" name="username" readonly="readonly" type="text" class="text" value="'.  $row['user_name'] . '"/></td></tr>';
	  echo '<tr><td><label for="imei">IMEI<span class="rq"> * </span></td><td><input class="required digits" id="imei" name="imei" type="text" class="text" maxlength="15" minlength="15" value="'.  $row['imei'] . '"/></td></tr>';
	  echo '<tr><td><label for="email">Email <span class="rq"> * </span></td><td><input class="required email" id="email" name="email" type="text" class="text" value="'.  $row['email'] . '"/></td></tr>';
	  echo '<tr><td><label for="mobi">Mobile <span class="rq"> * </span></td><td><input class="required digits" maxlength="12" name="mobi" type="text" class="text" value="'.  $row['phone_number'] . '"/></td></tr>';
	echo '</table>';
	echo '<input name="send" class="btTxt submit" type="submit" value="Submit"/>';
	echo '</form>';
}
?>

<script>
function handleChange(cb) {
  alert("Changed, new value = " + cb.checked);
}
</script>
</div><!--End container-->
<div id="container">
<center><h2>Change Password</h2></center>
<form id="contact2" method="post" action="../../Business/UpdateAccount/ChangePasswordDB.php" enctype="multipart/form-data" class="contact-formUpdate" >
<div id="tabel1">
<table>
<tr><td>old Password <span class="rq"> * </span></td><td><input class="required" minlength="6" id="passwordOld" name="passwordOld" type="password" class="password"/></td></tr>
<tr><td>New Password <span class="rq"> * </span></td><td><input class="required" minlength="6" id="passwordNew" name="passwordNew" type="password" class="password"/></td></tr>
<tr><td>Confirm password <span class="rq"> * </span></td><td><input class="required" name="cpasswordNew" type="password" class="password" /></td></tr>
</table>
</div>
<input name="send" class="btTxt submit" type="submit" value="Submit"/>
</form>
</div>
</div><!-- End center-->
</body>
</html>