<?php
session_start();
if(!isset($_SESSION['myname'])){
	echo "<script>window.location = '../../index2.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>History</title>
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
</script>
<link href="../../Common/CSS/History.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://azadcreative.com/wp-content/themes/Instinct/javascript/jquery.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"
		type="text/javascript"></script>
<script src="../../Business/Admin/admin.js"
		type="text/javascript"></script>
<script type="text/javascript" language="javascript"
		src="../../Common/JS/checkInput.js"></script>
<script type="text/javascript" language="javascript"
		src="../../Common/JS/popup/css-pop.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="../../Common/JS/jquery.tablescroll.js"></script>
<script src="../../Common/JS/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="../../Common/CSS/jquery.tablescroll.css"/>
</head>
<body style="margin:0px; padding:0px;" onload="initialize()">
<div class="center">
    <div class="header"><!-- Header -->
        <div class="infoAcc">Hi <a href="AccInfo.html"><?php 
				echo "<b>".$_SESSION["myname"]."</b>";
				?>
                </a> | <a href="../../Business/Login/LogOut.php">Log Out</a></div>
        <div class="navigation">
          <ul>
            <li class="config"><a href="http://google.com.vn"><span>Config</span></a></li>
            <li class="history selected"><a href="#"><span>History</span></a></li>
            <li class="danger Area"><a href="#"><span>Danger Area</span></a></li>
            <li class="contact"><a href="javascript:;"><span>Contact Us</span></a></li>
          </ul>
          <ul class="webSiteName">
             Mobile Tracking System
          </ul>
        </div>
    </div><!-- end Header -->
	<div class="tablescroll">

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
$query = "select * from " . $tableAccount;
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
echo '<table id="thetable">'; 
echo '<thead>
		<tr class="first">
			<th scope="">ID</th>
			<th scope="col">User Name</th>
			<th scope="col">Password</th>
			<th scope="col">Role</th>
			<th scope="col">Imei</th>
			<th scope="col">Phone Number</th>
			<th scope="col">Email</th>
		</tr>
		</thead>';
echo '<tbody>';	
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  echo '<tr onclick="rowEventClick()">';
  echo '<td>' . $row['id'] . '</td>';
  echo '<td>' . $row['user_name'] . '</td>';
  echo '<td>' . $row['password'] . '</td>';
  echo '<td>' . $row['role'] . '</td>';
  echo '<td>' . $row['imei'] . '</td>';
  echo '<td>' . $row['phone_number'] . '</td>';
  echo '<td>' . $row['email'] . '</td>';
  echo '</tr>';
}
// End XML file
echo '</tbody>';
echo '</table>'
?>
</div>
</div><!--end Center-->

<!--POPUP-->    

<div id="blanket" style="display:none;"></div>
<div id="popUpDiv" style="display:none;">
<a href="#" onclick="popup('popUpDiv','asdas')"><img src="../Image/Calendar/cal_close.gif" width="24" height="21" /></a>	
<div id="info"></div>

</div>	
<!-- / POPUP-->    
</body></html>
