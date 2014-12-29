<!DOCTYPE HTML>
<html>
<head>
	<title>Login to MTS System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="2cwebvn" />
	<link type="text/css" href="Common/CSS/style.css" rel="stylesheet">
	<script type="text/javascript" src="Common/JS/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="Common/JS/jquery.validate.min.js"></script>
	<script type="text/javascript" src="Common/JS/localization/messages_vi.js"></script>
    <script type="text/javascript" src="Common/JS/checkInput.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#tutorial").validate({
				errorElement: "span", 
				submitHandler: function(form) {
				
					
					var name        = $('#name').attr('value');
					var pwd       = $('#pwd').attr('value');
				 
					$.ajax({
						type: "POST", 
						url: "CheckLogin.php", 
						data: "name="+ name +"&pwd="+ pwd, 
						success: function(answer){ 
							$('form#tutorial').hide(); 
							$('div.success').fadeIn(); 
							$('div.success').html(answer); 
						}
					});
					return false;  
					 
				 }
			});
		});
</script>
<script>
function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}
function blanket_size(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportheight = window.innerHeight;
	} else {
		viewportheight = document.documentElement.clientHeight;
	}
	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
		blanket_height = viewportheight;
	} else {
		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
			blanket_height = document.body.parentNode.clientHeight;
		} else {
			blanket_height = document.body.parentNode.scrollHeight;
		}
	}
	var blanket = document.getElementById('blanket');
	blanket.style.height = blanket_height + 'px';
	var popUpDiv = document.getElementById(popUpDivVar);
	popUpDiv_height=blanket_height/2-200;
	//200 is half popup's height
	popUpDiv.style.top = popUpDiv_height + 'px';
}
function window_pos(popUpDivVar) {
	if (typeof window.innerWidth != 'undefined') {
		viewportwidth = window.innerHeight;
	} else {
		viewportwidth = document.documentElement.clientHeight;
	}
	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
		window_width = viewportwidth;
	} else {
		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
			window_width = document.body.parentNode.clientWidth;
		} else {
			window_width = document.body.parentNode.scrollWidth;
		}
	}
	var popUpDiv = document.getElementById(popUpDivVar);
	window_width=window_width/2-200;
	//200 is half popup's width
	popUpDiv.style.left = window_width + 'px';
}
function popup(windowname) {
	blanket_size(windowname);
	window_pos(windowname);
	toggle('blanket');
	toggle(windowname);		
}
</script>
<style>
@charset "UTF-8";
body {
}




/*STYLES FOR CSS POPUP*/


#blanket {
}

#popUpDiv {
	padding-left:20px;
	text-align:left;
	position:absolute;
	background:#7092BE;
	width:350px;
	height:250px;
	border:5px solid #000;
	z-index: 9002;
}

</style>
</head>
<body>
<form id="tutorial" action="CheckLogin.php" method="post">

    <p><label >Username:</label>
    <input class="login" type="text" name="name" id="name" class="required" minlength="" onKeypress="checkSpecialCharacter()"/></p>
    <p><label for="pwd">Password:</label>
    <input class="login" type="password" name="pwd" id="pwd" onKeypress="checkSpecialCharacter()"/></p>
    <p><a href="RegisterSite.php">Create an account</a> |
        <a href="#" onclick="popup('popUpDiv')">Forgot password?</a></p>
    <p class="submit"><input id="submit" type="submit" value="Sign in" /></p>

</form>
<!--POPUP-->    
    
    <div id="blanket" style="display:none;"></div>
	<div id="popUpDiv" style="display:none;">
    <br /><br />
If you forget your password, please contact us.<br />
MTS Team<br />
<br /><br />
<table border="0" cellspacing="0" cellpadding="0">
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
<br /><br />
    	<a href="#" onclick="popup('popUpDiv')" >Click to Close</a>
	</div>	
  
<!-- / POPUP-->    
<div class="success" style="display:none;"></div>
</body>
</html>