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
<title>Danger Area</title>
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
<script type="text/javascript" language="javascript"
		src="../../../Common/JS/checkInput.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	   <script type="text/javascript" language="javascript"
			src="../../Business/Marker/showMarkers.js"></script>
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
            <li class="history"><a href="../History/Location/showHistory.php"><span>History</span></a></li>
            <li class="danger Area selected"><a href="javascript:;"><span>Danger Area</span></a></li>
            <li class="contact"><a href="javascript:;"><span>Contact Us</span></a></li>
          </ul>
          <ul class="webSiteName">
             Mobile Tracking System
          </ul>
        </div>
    </div><!-- end Header -->
   
    <div class="MapInfo">
        <div class="map" id="map"><!-- Map div -->
        </div><!--end Map div -->
        
        <div class="listLocation"><!-- List Location div-->
          <span>List Of Location</span>
          <br>
          <p id="date"></p>
          <div id="side_bar"></div>
         </div><!--end List Location div -->
  		<div class="parameter">
        <span>Parameter</span>
        <div class="parameterInfo">
         <script>
			function disable(){
			document.getElementById("TimeText").disabled = true;
        }
			function enable(){
			document.getElementById("TimeText").disabled = false;
        }
        </script>
          <p>
            <label>
              <input type="radio" name="RadioGroup1" value="radio" id="RadiorealTime" onclick="disable()"/>
              Tracking Real Time</label>
            <br />
            <label>
              <input type="radio" name="RadioGroup1" value="radio" id="RadioTime" onclick="enable()" checked="checked"/>
              Time upload Data</label><input name="TimeText" type="text" id="time"/>
            <br />
            <input name="submit" type="button" value="OK" onclick="updateParameter()"/>
          </p>
         </div>
  		</div>

  </div><!--end Map info div-->
</div><!--end Center-->
</body></html>
