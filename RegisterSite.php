<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>REGISTRATION</title>
	<link type="text/css" href="Common/CSS/resgister.css" rel="stylesheet">
	<script type="text/javascript" src="Common/JS/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="Common/JS/jquery.validate.min.js"></script>
	<script type="text/javascript" src="Common/JS/localization/messages_vi.js"></script>
    <script type="text/javascript" src="Common/JS/checkInput.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#contact").validate({
				errorElement: "span", 
				rules: {
					cpassword: {
						equalTo: "#password" 
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
<div id="container">
	<form id="contact" method="post" action="ConfirmSite.php" enctype="multipart/form-data" class="contact-form" >
		<center><h2>Mobile Tracking System Registration</h2></center>
        
		<table>
			<tr>
                <td><label for="name">Username <span class="rq"> * </span></label></td>
                <td><input class="required" minlength="6" maxlength="12" id="username" name="username" type="text" class="text" size="30"/></td>
			</tr>
			<tr>
				<td><label for="name">Password <span class="rq"> * </span></label></td>
				<td><input class="required" minlength="6" maxlength="12" id="password" name="password" type="password" class="text" onKeypress="checkSpecialCharacter()" size="30"/></td>
			</tr><tr>
				<td><label for="name">Confirm password <span class="rq"> * </span></label></td>
				<td><input class="required" name="cpassword"  minlength="6" maxlength="12" type="password" class="password" onKeypress="checkSpecialCharacter()" size="30"/></td>
			</tr>
            <tr>
				<td><label for="imei">IMEI<span class="rq"> * </span></label></td>
				<td><input class="required digits" id="imei" name="imei" type="text" class="text" maxlength="15" minlength="15" size="30"/></td>
			</tr>
			<tr>
				<td><label for="email">Email <span class="rq"> * </span></label></td>
				<td><input class="required email" id="email" name="email" type="text" class="text" size="30"/></td>
			</tr>
			<tr>
				<td><label for="mobi">Mobile <span class="rq"> * </span></label></td>
				<td><input class="required digits" maxlength="12" name="mobi" type="text" class="text" size="30"/></td>
			</tr>			
			
			<tr>
				<td></td><td><input name="send" class="btTxt submit" type="submit" value="Submit"/><input type="button" class="btTxt submit" VALUE="Log In" onclick="window.location.href='index.php'"/></td>
			</tr>
		</table>
	</form> 
</div><!--End container-->
</body>
</html>