<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact</title>
<link href="Common/CSS/History.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="center">
    <div class="header"><!-- Header -->
        <div class="infoAcc">Hi <a href="updateAccount.php"><?php 
				echo "<b>".$_SESSION["myname"]."</b>";
				?>
                </a> | <a href="Business/Login/LogOut.php">Log Out</a></div>
        <div class="navigation">
          <ul>
            <li class="updateAccount"><a href="updateAccount.php"><span>Update Account</span></a></li>
            <li class="history"><a href="showHistory.php"><span>History</span></a></li>
            <li class="danger Area"><a href="dangerArea.php"><span>Danger Area</span></a></li>
            <li class="contact selected"><a href=""><span>Contact Us</span></a></li>
            <li class="download"><a href="download.php"><span>Download</span></a></li>
          </ul>
          <ul class="webSiteName">
             Mobile Tracking System
          </ul>
        </div>
    </div><!-- end Header -->
    <div class="contactUs">
Thanks for using MTS system<br />
If you have any question or comment, please contact us.<br />

MTS Team<br />

<table border="0" cellspacing="2" cellpadding="2">
  <tr>
     <td><b style="color:#000">Address:</b></td>
    <td><b style="color:#000">&nbsp;&nbsp;&nbsp;&nbsp; Ha Noi</b></td>
  </tr>
  <tr>
    <td><b style="color:#000">Phone Number:</b></td>
    <td><b style="color:#000">&nbsp;&nbsp;&nbsp;&nbsp; 0912345678</b></td>
  </tr>
  <tr>
    <td><b style="color:#000">Email:</b></td>
    <td><b style="color:#000">&nbsp;&nbsp;&nbsp;&nbsp; mtsTeam@gmail.com</b></td>
  </tr>
</table>

</div>
</div>
</body>
</html>
