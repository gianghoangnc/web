<?php
session_start();
if(!isset($_SESSION['myname'])){
	echo "<script>window.location = '../../../index2.php'</script>";
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
<link href="../../../Common/CSS/History.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript"
		src="../../../Common/JS/popup/css-pop.js"></script>
<script type="text/javascript" src="http://azadcreative.com/wp-content/themes/Instinct/javascript/jquery.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"
		type="text/javascript"></script>
<script type="text/javascript" language="javascript"
		src="../../../Common/JS/checkInput.js"></script>
<script type="text/javascript" language="javascript"
		src="../../../Business/History/Location/showHistory.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="../../../Common/JS/jquery.tablescroll.js"></script>
<script src="../../../Common/JS/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="../../../Common/CSS/jquery.tablescroll.css"/>
</head>
<body style="margin:0px; padding:0px;" onload="initialize()">
<div class="center">
    <div class="header"><!-- Header -->
        <div class="infoAcc">Hi <a href="../../Account/updateAccount.php"><?php 
				echo "<b>".$_SESSION["myname"]."</b>";
				?>
                </a> | <a href="../../../Business/Login/LogOut.php">Log Out</a></div>
        <div class="navigation">
          <ul>
            <li class="config"><a href="http://google.com.vn"><span>Config</span></a></li>
            <li class="history selected"><a href=""><span>History</span></a></li>
            <li class="danger Area"><a href="../../Marker/dangerArea.php"><span>Danger Area</span></a></li>
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
          <br />
          <p id="distance"></p>
          <br />
          <p><b>Freeze Point</b></p>
          <div id="listLocation"></div>
         </div><!--end List Location div -->
         
        <div class="listDangerArea"><!-- List Danger Area div-->
          <span style="color: #F00;">List of Danger Area</span>
          <div id="listDangerArea"></div>
         </div><!-- List Danger Area div -->
        
    </div><!--end Map info div-->
	<div class="historyInfo">
    	<div class="time">
        	<label for="demo1">Please enter a date here &gt;&gt; </label>
			<input type="text" id="demo1" maxlength="25" size="25" onchange="pickedDate(map)"/>
			<img src="../../../Inteface/Image/Calendar/cal.gif" onclick="javascript:NewCssCal('demo1')" style="cursor:pointer"/>
        </div>


        <div class="sms" id="sms">
        	<div class="tablescroll">
            		<div class="title">SMS</div>
					<table id="thetableSMS" cellspacing="0" width="580px" height="230px">
					<thead>
                    <span id="statusSMS"></span>

				    </thead>
						<tbody id = "tableDataSMS">
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr> 
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>                                                                            
						</tbody>
						</table>

			</div>
        </div>
        <div class="callLog">
        	<div class="tablescroll">
            		<div class="title">CALL LOG</div>
					<table id="thetableCallLog" cellspacing="0" width="580px" height="230px">
					<thead>
                    <span id="statusCallLog"></span>

				    </thead>
						<tbody id = "tableDataCallLog">
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr> 
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>                                                                            
						</tbody>
						</table>

			</div>
        </div>        
        </div>
    </div>
	<script>
jQuery(document).ready(function($)
{
$('#thetableSMS').tableScroll({height:210});

$('#thetableCallLog').tableScroll({height:210});

});
</script>
</div><!--end Center-->

<!--POPUP-->    
    
    <div id="blanket" style="display:none;"></div>
<div id="popUpDiv" style="display:none;">
	<a href="#" onclick="popup('popUpDiv','asdas')"><img src="../../Image/Calendar/cal_close.gif" width="24" height="21" /></a>	
  <div id="info"></div>
   	    
  </div>	
<!-- / POPUP-->    

</body></html>
