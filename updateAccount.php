<?php
session_start();
if(!isset($_SESSION['myname'])){
	echo "<script>window.location = 'index.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Update Account</title>
    </script>
<link href="Common/CSS/History.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="Common/CSS/style.css" rel="stylesheet">
	<script type="text/javascript" src="Common/JS/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="Common/JS/jquery.validate.min.js"></script>
	<script type="text/javascript" src="Common/JS/localization/messages_vi.js"></script>
    <script type="text/javascript" src="Common/JS/checkInput.js"></script>
    <script src="Common/JS/datetimepicker_css.js"></script>
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
        <div class="infoAcc">Hi <a href="#"><?php 
				echo "<b>".$_SESSION["myname"]."</b>";
				?>
                </a> | <a href="Business/Login/LogOut.php">Log Out</a></div>
        <div class="navigation">
          <ul>
            <li class="updateAccount selected"><a href="#"><span>Update Account</span></a></li>
            <li class="history"><a href="showHistory.php"><span>History</span></a></li>
            <li class="danger Area"><a href="dangerArea.php"><span>Danger Area</span></a></li>
            <li class="contact"><a href="contact.php"><span>Contact Us</span></a></li>
            <li class="download"><a href="download.php"><span>Download</span></a></li>
          </ul>
          <ul class="webSiteName">
             Mobile Tracking System
          </ul>
        </div>
    </div><!-- end Header -->
<div id="container">
<?php
require("Common/DatabaseCommon/phpsqlajax_dbinfo.php");
require("Common/EncryptDecrypt/Encrypy_Decrypt.php");
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
$user_name = encrypt($user_name, $key);
$query = "select * from " . $tableAccount . " where user_name='" . $user_name . "'";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
else{
	$row = @mysql_fetch_assoc($result);
	echo '<form id="contact" method="post" action="Business/UpdateAccount/updateAccountDB.php" enctype="multipart/form-data" class="contact-form" >';
	echo '<center><h2>Update</h2></center>';
	echo '<table>';
	// Iterate through the rows, printing XML nodes for each
	  echo '<tr><td>Username <span class="rq"> * </span></td><td><input class="required" minlength="6" id="username" name="username" readonly="readonly" type="text" size="30" class="text" value="'.  decrypt($row['user_name'], $key) . '"/></td></tr>';
	  echo '<tr><td><label for="imei">IMEI<span class="rq"> * </span></td><td><input class="required digits" id="imei" name="imei" type="text" size="30" class="text" maxlength="15" minlength="15" value="'.  decrypt($row['imei'], $key) . '"/></td></tr>';
	  echo '<tr><td><label for="email">Email <span class="rq"> * </span></td><td><input class="required email" id="email" name="email" type="text" size="30" class="text" value="'.  decrypt($row['email'], $key) . '"/></td></tr>';
	  echo '<tr><td><label for="mobi">Mobile <span class="rq"> * </span></td><td><input class="required digits" maxlength="12" name="mobi" type="text" size="30" class="text" value="'.  decrypt($row['phone_number'], $key). '"/></td></tr>';
	  echo '<tr><td></td><td><input name="action" type="submit" value="update" /></td></tr>';
	echo '</table>';
	
	echo '</form>';
}
?>

</div><!--End container-->

<div id="container">
        <form id="delete" method="post" action="Business/UpdateAccount/updateAccountDB.php" enctype="multipart/form-data "class="delete-formUpdate">
        	<label for="demo1">Please enter a date here &gt;&gt; </label>
			<input type="text" id="demo1" name="demo1" maxlength="25" size="25" value="<?php $systemDate = date("Y-m-d");
		  				      echo $systemDate;?>" readonly="readonly" style="height:20px; font-size:15px;"/>
			<img src="Common/Image/Calendar/cal.gif" onclick="javascript:NewCssCal('demo1')" style="cursor:pointer"/>
			<table width="200">
			  <tr>
			    <td><label>
			      <input type="checkbox" name="CheckboxGroup1" value="Tracking" id="CheckboxGroup1_0" />
			      Data Tracking</label></td>
		      </tr>
			  <tr>
			    <td><label>
			      <input type="checkbox" name="CheckboxGroup2" value="SMS" id="CheckboxGroup1_1" />
			      Data SMS</label></td>
		      </tr>
			  <tr>
			    <td><label>
			      <input type="checkbox" name="CheckboxGroup3" value="CallLog" id="CheckboxGroup1_2" />
			      Data Call Log</label></td>
		      </tr>
              <tr><td><input name="action" type="submit" value="Delete" size="20"/>&nbsp;&nbsp;<input name="action" type="submit" value="Backup" size="20"/></td></tr>
		  </table>
        </form>    
            
</div>

<div id="container">
<center><h2>Change Password</h2></center>
<form id="contact2" method="post" action="Business/UpdateAccount/updateAccountDB.php" enctype="multipart/form-data" class="contact-formUpdate" >
<div id="tabel1">
<table>
<tr><td>old Password <span class="rq"> * </span></td><td><input class="required" minlength="6" id="passwordOld" name="passwordOld" type="password" class="password" onKeypress="checkSpecialCharacter()"/></td></tr>
<tr><td>New Password <span class="rq"> * </span></td><td><input class="required" minlength="6" maxlength="12" id="passwordNew" name="passwordNew" type="password" class="password" onKeypress="checkSpecialCharacter()"/></td></tr>
<tr><td>Confirm password <span class="rq"> * </span></td><td><input class="required" name="cpasswordNew" type="password" class="password" maxlength="12" onKeypress="checkSpecialCharacter()"/></td></tr>
<tr><td></td><td><input name="action" type="submit" value="ChangePassword" /></td></tr>
</table>
</div>
</form>
</div>
</div><!-- End center-->
</body>
</html>