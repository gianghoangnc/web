function rowEventClick() {
    var table = document.getElementById("thetable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
			return function() { 
				var id = row.getElementsByTagName("td")[0].innerHTML;
				var user_name = row.getElementsByTagName("td")[1].innerHTML;
				var passWord = row.getElementsByTagName("td")[2].innerHTML;
				var role = row.getElementsByTagName("td")[3].innerHTML;
				var imei = row.getElementsByTagName("td")[4].innerHTML;
				var phone_number = row.getElementsByTagName("td")[5].innerHTML;
				var email = row.getElementsByTagName("td")[6].innerHTML;
				var windowname = 'popUpDiv';
				var html = "";
				html += '<div id="container">';
			    html += '<form name="form1" method="post" action="Common/DatabaseCommon/accountDBFuntion.php" enctype="multipart/form-data" class="contact-form">';
				html += '<span><b>Account Info</b></span>';
				html += '<br><br><table id="AccountInfo" border="1" cellspacing="1" cellpadding="1" width="350">';
				html += '<thead>';
				html += '</thead>';
				html += '<tbody>';
				html += '<tr><td><b>Id</b></td><td><input name="id" type="text" value="'+ id +'" size="5" readonly="readonly" style="background:#d0e4fe;"/></td></tr>';
				html += '<tr><td><b>User Name</b></td><td><input name="user_name" type="text" value="'+ user_name +'" size="10" readonly="readonly" style="background:#d0e4fe;"/></td></tr>';
				var labelRole = '';
				var labelRoleAnother1 = '';
				var roleAnother1 = '';
				var labelRoleAnother2 = '';
				var roleAnother2 = ''; 
				if(role==1){
					labelRole = 'Admin';
					labelRoleAnother1 = 'User';
					labelRoleAnother2 = 'Locked';
					roleAnother1 = 2;
					roleAnother2 = 0;
				}
				else if(role==2){
					labelRole = 'User';
					labelRoleAnother1 = 'Admin';
					labelRoleAnother2 = 'Locked';
					roleAnother1 = 1;
					roleAnother2 = 0;
				}
				else if(role==0){
					labelRole = 'Locked';
					labelRoleAnother1 = 'Admin';
					labelRoleAnother2 = 'User';
					roleAnother1 = 1;
					roleAnother2 = 2;
				}
				html += '<tr><td><b>Role</b></td><td><select name="role"><option value="'+roleAnother1+'">'+labelRoleAnother1+'</option><option value="'+roleAnother2+'">'+labelRoleAnother2+'</option><option selected="selected" value="'+ role+'">' + labelRole +'</option></select></td></tr>';
				html += '<tr><td>IMEI</td><td><input name="imei" class="required digits" maxlength="15" minlength="15" type="text" value="'+ imei +'" size="20" onkeypress="return isNumberKey(event)"/></td></tr>';
				html += '<tr><td>Mobile</td><td><input name="phone_number" class="required digits" type="text" value="'+ phone_number +'" size="20" maxlength="12" onkeypress="return isNumberKey(event)"/></td></tr>';
				html += '<tr><td>Email</td><td><input name="email" class="required email" type="text" value="'+ email +'" size="30"/></td></tr>';
				html += '</table>';
				html += '<div class="button"><input name="action" type="submit" value="update" onclick = "return ValidateForm()"/><input name="action" type="submit" value="delete" /><input name="action" type="submit" value="resetPassword" /></div>';
				html +='<br><br><br>';
				html += '</form>';
				html += '</div>';
				popup(windowname,html);
			};
            }
        currentRow.onclick = createClickHandler(currentRow);
    }
}

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}