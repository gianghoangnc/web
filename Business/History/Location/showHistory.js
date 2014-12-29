var gmarkersLocationGloBal = [];
var gmarkersGloBal = [];
var overlays = [];
var polyLine = [];
function pickedDate(map){

	var textbox = document.getElementById("demo1");
	var textbox2 = document.getElementById("mobileNumber");
	var onchangeHandler = function(textbox){
		return function(){
			var time = document.getElementById("demo1").value;
			var mobileNumber = document.getElementById("mobileNumber").value;
			removeMarkers();
			displayFreeLocation(time, map);
			drawPolyLineFormAllLocation(time, map);
			displaySMS(time,mobileNumber);
			displayCallLog(time,mobileNumber);
		};
	}
	textbox.onchange = onchangeHandler(textbox);
	textbox2.onchange = onchangeHandler(textbox2);
}

// function for row click event
function rowEventClickCallLog() {
    var table = document.getElementById("thetableCallLog");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
			return function() { 
				var id = row.getElementsByTagName("td")[0].innerHTML;
				var type = row.getElementsByTagName("td")[1].innerHTML;
				var phone_number = row.getElementsByTagName("td")[2].innerHTML;
				var time = row.getElementsByTagName("td")[3].innerHTML;
				var duration = row.getElementsByTagName("td")[4].innerHTML;
				var windowname = 'popUpDiv';
				var html = "";
				html = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Call Log Info</b></span>";
				html += "<br><br><table id='CallLogInfo' border='1' cellspacing='1' cellpadding='1' width='350'>";
				html += "<thead>";
				html += "</thead>";
				html += "<tbody>";
				html += "<tr><td><b>Id</b></td><td>"+ id + "</td></tr>";
				html += "<tr><td><b>Type</b></td><td>"+ type + "</td></tr>";
				html += "<tr><td><b>Phone Number</b></td><td>"+ phone_number + "</td></tr>";
				html += "<tr><td><b>Time</b></td><td>"+ time + "</td></tr>";
				html += "<tr><td><b>Duration</b></td><td>"+ duration + " s</td></tr>";
				html += "</tbody>";
				html += "</table>";
				popup(windowname,html);
			};
            }
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function rowEventClickSMS() {
    var table = document.getElementById("thetableSMS");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
			return function() { 
				var id = row.getElementsByTagName("td")[0].innerHTML;
				var type = row.getElementsByTagName("td")[1].innerHTML;
				var phone_number = row.getElementsByTagName("td")[2].innerHTML;
				var time = row.getElementsByTagName("td")[3].innerHTML;
				var content = row.getElementsByTagName("td")[4].innerHTML;
				var windowname = 'popUpDiv';
				var html = "";
				html = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>SMS Info</b></span>";
				html += "<br><br><table id='CallLogInfo' border='1' cellspacing='1' cellpadding='1' width='350'>";
				html += "<thead>";
				html += "</thead>";
				html += "<tbody>";
				html += "<tr><td><b>Id</b></td><td>"+ id + "</td></tr>";
				html += "<tr><td><b>Type</b></td><td>"+ type + "</td></tr>";
				html += "<tr><td><b>Phone Number</b></td><td>"+ phone_number + "</td></tr>";
				html += "<tr><td><b>Time</b></td><td>"+ time + "</td></tr>";
				html += "<tr><td><b>Content</b></td><td><textarea rows='8' cols='30' style='background:#d0e4fe;' readonly='readonly'>"+ content.substr(125) +"</textarea></td></tr>";
				html += "</tbody>";
				html += "</table>";
				popup(windowname,html);
			};
            }
        currentRow.onclick = createClickHandler(currentRow);
    }
}
var customIcons = {
	start :{
		icon:'http://www.google.com/mapfiles/dd-start.png'
	},
	end :{
		icon:'http://www.google.com/mapfiles/dd-end.png'
	},
	passedLocation: {
		icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
	},
	warningPassedLocation:{
		icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png'
	},
	marker: {
		icon: 'http://maps.google.com/mapfiles/kml/pal3/icon33.png',
		shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
	}
	};

	// === This function picks up the click and opens the corresponding info window ===
	  function myclickGmarkersLocation(i) {
        google.maps.event.trigger(gmarkersLocationGloBal[i],"click");
      }
	 function myclickGmarkers(i) {
        google.maps.event.trigger(gmarkersGloBal[i],"click");
      }
	 function myclickPolyLine(i) {
        google.maps.event.trigger(polyLine[i],"click");
      }
$(document).ready(function(){
						   
$('#thetableSMS').tableScroll({height:210});

$('#thetableCallLog').tableScroll({height:210});

$('#thetableDangerArea').tableScroll({height:550});

$('#thetableListFreezePoint').tableScroll({height:355});

  var mapOptions = {
       zoom: 13,
       mapTypeId: google.maps.MapTypeId.ROADMAP,
       center: new google.maps.LatLng(21.0256, 105.844)
     };

  var map = new google.maps.Map(document.getElementById("map"),mapOptions);
		removeMarkers();
		displayFreeLocation("", map);
		drawPolyLineFormAllLocation("", map);
		displaySMS("","");
		displayCallLog("","");
		pickedDate(map);
	var geocoder = new google.maps.Geocoder();  

     $(function() {
         $("#searchbox").autocomplete({
         
           source: function(request, response) {

          if (geocoder == null){
           geocoder = new google.maps.Geocoder();
          }
             geocoder.geocode( {'address': request.term }, function(results, status) {
               if (status == google.maps.GeocoderStatus.OK) {

                  var searchLoc = results[0].geometry.location;
               var lat = results[0].geometry.location.lat();
                  var lng = results[0].geometry.location.lng();
                  var latlng = new google.maps.LatLng(lat, lng);
                  var bounds = results[0].geometry.bounds;

                  geocoder.geocode({'latLng': latlng}, function(results1, status1) {
                      if (status1 == google.maps.GeocoderStatus.OK) {
                        if (results1[1]) {
                         response($.map(results1, function(loc) {
                        return {
                            label  : loc.formatted_address,
                            value  : loc.formatted_address,
                            bounds   : loc.geometry.bounds
                          }
                        }));
                        }
                      }
                    });
            }
              });
           },
           select: function(event,ui){
      var pos = ui.item.position;
      var lct = ui.item.locType;
      var bounds = ui.item.bounds;

      if (bounds){
       map.fitBounds(bounds);
      }
           }
         });
     });   
 });	  

function if_gmap_getdistance(point1, point2)
{
        var radfactorval = 3.1459/180;
        var lat1 = point1.lat();
        var lat2 = point2.lat();
        var lon1 = point1.lng();
        var lon2 = point2.lng();
	var R = 6371; // km
	var dLat = (lat2-lat1)*radfactorval;
	var dLon = (lon2-lon1)*radfactorval; 
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
	        Math.cos(lat1*radfactorval) * Math.cos(lat2*radfactorval) * 
	        Math.sin(dLon/2) * Math.sin(dLon/2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	var d = R * c * 1000;
	return d;
}
	function calcRoute(map) {
	  var locations;

	   downloadUrl("Business/History/Location/phpsqlajax_genxmlAllLocation.php", function(data) {

	   	var waypts = [];

        var xml = data.responseXML;
         locations = xml.documentElement.getElementsByTagName("location");		
        for (var i = 0; i < 10; i++) {
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();
          var id = locations[i].getAttribute("id");
          var timeStamp = locations[i].getAttribute("Timestamp");
		var start = new google.maps.LatLng(
              parseFloat(locations[i].getAttribute("Latitude")),
              parseFloat(locations[i].getAttribute("Longitude")));
		var end = new google.maps.LatLng(
              parseFloat(locations[i+1].getAttribute("Latitude")),
              parseFloat(locations[i+1].getAttribute("Longitude")));
	  	var request = {
					origin: start,
					destination: end,
					optimizeWaypoints: false,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				};
				  directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
					  directionsDisplay.setDirections(response);
					}
				  });
				  directionsDisplay.setMap(map);
				  overlays.push(directionsDisplay);
			}

});

}	
	 function drawPolyLineFormAllLocation(time, map){
		polyLine=[];
	 document.getElementById("date").innerHTML = 'Loading...';
	 document.getElementById("distance").innerHTML = '';
	  var arrayPoint = [];
	  var locations;
	  var date = document.getElementById("demo1").value;
	  var url = "Business/History/Location/phpsqlajax_genxmlAllLocation.php?time=" + time;
	   downloadUrl(url, function(data) {
        var xml = data.responseXML;
         locations = xml.documentElement.getElementsByTagName("location");
		 if(locations.length==0){
			 document.getElementById("date").innerHTML = 'Have no data for <br><b>'+date+'</b>';
			 }
		 else{
		//get All Location
		  var id1 = locations[0].getAttribute("id");
          var timeStamp1 = locations[0].getAttribute("TimeStamp");
          var point1 = new google.maps.LatLng(
              parseFloat(locations[0].getAttribute("Latitude")),
              parseFloat(locations[0].getAttribute("Longitude")));
		  
          var html1 = "<b>ID: " + id1 + "</b><br/>Time From: " + timeStamp1;
          var icon1 = customIcons["start"] || {};
		  var location1 = new creatALocation(map, icon1, point1, html1, true);
		  
		  var id2 = locations[locations.length-1].getAttribute("id");
          var timeStamp2 = locations[locations.length-1].getAttribute("TimeStamp");
          var point2 = new google.maps.LatLng(
              parseFloat(locations[locations.length-1].getAttribute("Latitude")),
              parseFloat(locations[locations.length-1].getAttribute("Longitude")));
          var html2 = "<b>ID: " + id2 + "</b><br/>Time From: " + timeStamp2;
          var icon2 =customIcons["end"] || {};
		  var location2 = new creatALocation(map, icon2, point2, html2, true);
		  polyLine.push(location1); 
		  polyLine.push(location2); 
		 
		  document.getElementById("date").innerHTML = '<a href="javascript:myclickPolyLine(' + 0 + ')">Start: </a>' + timeStamp1 + '<br><a href="javascript:myclickPolyLine(' + 1 + ')">End: </a>' + timeStamp2 ;
		  //var distance = if_gmap_getdistance(point1, point2)/1000; 
		  //var distance = 0;
		   //document.getElementById("distance").innerHTML = '<b>Distance: </b>' + distance.toFixed(3) + ' km';
        for (var i = 0; i < locations.length; i++) {
		 
		var point = new google.maps.LatLng(
              parseFloat(locations[i].getAttribute("Latitude")),
              parseFloat(locations[i].getAttribute("Longitude")));
		
		arrayPoint.push(point);
			//var distanceBuf = if_gmap_getdistance(point, point2)/1000; 
			//distance = distance + distanceBuf;
		}
		//document.getElementById("distance").innerHTML = '<b>Distance: </b>' + distance.toFixed(3) + ' km';
		var flightPath = new google.maps.Polyline({
				path: arrayPoint,
				strokeColor: "#FF0000",
				strokeOpacity: 1.0,
				strokeWeight: 2
		});
		
		flightPath.setMap(map);	
		overlays.push(flightPath);
		}	
		});
	  
	  }
      function removeMarkers() {
		  while(overlays[0]){
		   overlays.pop().setMap(null);
		  }
      }
	  // Set Data for table SMS
	  function displaySMS(time, mobileNumber){
	  var date = document.getElementById("demo1").value;
	  var url = "Business/History/SMS/genSms.php?time=" + time + "&mobileNumber=" + mobileNumber;
	  var smsGen;
	  var sms_html = "";
	  var status = "";
	  document.getElementById("tableDataSMS").innerHTML = "<b>Loading...</b>";
	  document.getElementById("statusSMS").innerHTML = time;
      downloadUrl(url, function(data) {       
	  var xml = data.responseXML;
        smsGen = xml.documentElement.getElementsByTagName("sms");
		if(smsGen.length==0){
			document.getElementById("tableDataSMS").innerHTML = "<b>Have no data</b>";
			}
		else {
		//get All SMS
			sms_html += '<tr class="first"><th scope="">ID</th> <th scope="col">Type</th><th scope="col">Phone Number</th><th scope="col">Time</th><th scope="col">Content</th></tr>';
			for (var i = 0; i < smsGen.length; i++) {	
			  var id = smsGen[i].getAttribute("id");
			  var type = smsGen[i].getAttribute("type");
			  var phone_number = smsGen[i].getAttribute("phone_number");
			  var time = smsGen[i].getAttribute("time");
			  var content = smsGen[i].getAttribute("content");
			  sms_html += '<tr onclick="rowEventClickSMS();"><td>'+ id +'</td><td>'+ type +'</td><td>'+ phone_number +'</td><td>'+ time +'</td><td><textarea rows="2" cols="28" style="background:#d0e4fe; border-width: 0px 0px 0px 0px;overflow: hidden;" readonly="readonly">'+ content +'</textarea></td>';
			  status = smsGen[i].getAttribute("dateTime");
			 }
			document.getElementById("statusSMS").innerHTML = status;
			document.getElementById("tableDataSMS").innerHTML = sms_html;
		}
	  });
	  }
	  
	 //set data for table Call Log
	  function displayCallLog(time,mobileNumber){
	  var date = document.getElementById("demo1").value;
	  var url = "Business/History/CallLog/genCallLog.php?time=" + time + "&mobileNumber=" + mobileNumber;
	  var callLogGen;
	  var callLog_html = "";
	  var status = "";
	  document.getElementById("tableDataCallLog").innerHTML = "<b>Loading...</b>";
	  document.getElementById("statusCallLog").innerHTML = time;
      downloadUrl(url, function(data) {       
	  var xml = data.responseXML;
        callLogGen = xml.documentElement.getElementsByTagName("calllog");
		if(callLogGen.length==0){
			document.getElementById("tableDataCallLog").innerHTML = "<b>Have no data</b>";

			}
		else {
		//get All Call Log
		callLog_html += '<tr class="first"><th scope="">ID</th> <th scope="col">Type</th><th scope="col">Phone Number</th><th scope="col">Time</th><th scope="col">Duration</th></tr>';
			for (var i = 0; i < callLogGen.length; i++) {	
			  var id = callLogGen[i].getAttribute("id");
			  var type = callLogGen[i].getAttribute("type");
			  var phone_number = callLogGen[i].getAttribute("phone_number");
			  var time = callLogGen[i].getAttribute("time");
			  var duration = callLogGen[i].getAttribute("duration");
			  callLog_html += '<tr onclick="rowEventClickCallLog();"><td>'+ id +'</td><td>'+ type +'</td><td>'+ phone_number +'</td><td>'+ time +'</td><td>'+ duration +'</td>';
			  status = callLogGen[i].getAttribute("dateTime");
			 }
			document.getElementById("statusCallLog").innerHTML = status;
			document.getElementById("tableDataCallLog").innerHTML = callLog_html;
		}
	  });
	  
	  }
	  
	  function displayFreeLocation(time,map){
		gmarkersLocationGloBal = [];
		gmarkersGloBal = [];
	  var locations;
	  var markers;
	  var side_bar_html = "";
	  var side_bar_markers_html = "";
	  var markerDataArray = [];
	  var locationDataArray = [];
	  	var url = "Business/History/Location/phpsqlajax_genxml3.php?time=" + time;
      downloadUrl(url, function(data) {
        var xml = data.responseXML;
         locations = xml.documentElement.getElementsByTagName("location");		
		//get All Location
		
        for (var i = 0; i < locations.length; i++) {
          var id = locations[i].getAttribute("id");
          var timeStamp = locations[i].getAttribute("TimeStamp");
          var count = locations[i].getAttribute("count");
		  var intCount = parseInt(count); 
          var point = new google.maps.LatLng(
              parseFloat(locations[i].getAttribute("Latitude")),
              parseFloat(locations[i].getAttribute("Longitude")));
          var html = "<b>ID: " + id + "</b><br/>Time From: " + timeStamp + "<br/>In: " +  intCount.toFixed(3) +" min";
          var icon = customIcons["passedLocation"] || {};
		  var location = new creatALocation(map, icon, point, html, true);
		  
		  var locationData = new storeLocationData(point, id, timeStamp, html);
		 gmarkersLocationGloBal.push(location); 
		 locationDataArray.push(locationData);
		 side_bar_html += '<tr><td><a href="javascript:myclickGmarkersLocation(' + i + ')">' + id + '<\/a></td></tr>';
        }
		

		
		//get All Markers

         markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var id = markers[i].getAttribute("id");
          var name = markers[i].getAttribute("Name");
          var comment = markers[i].getAttribute("Comment");
		  var radius = markers[i].getAttribute("Radius");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("Latitude")),
              parseFloat(markers[i].getAttribute("Longitude")));
		  var createdAt = markers[i].getAttribute("createdAt");
          var html = "<table>" +
                 "<tr><td>Name:</td> <td><input type='text' id='name' value='" + name +"'/></td> </tr>" +
                 "<tr><td>Comment:</td> <td><textarea id='comment' rows='3' cols='16'>"+comment+"</textarea></td> </tr>" +
                 "<tr><td>Radius:</td> <td><input type='text' id='radius' onkeypress='return isNumberKey(event)' value='" + radius + "'/> m</td></tr>" +
				 "<tr><td>Last update :</td> <td><input type='text' disabled='disabled' id='tag' value='"+ createdAt +"'/></td> </tr>";
          var icon = customIcons["marker"] || {};
          var marker = new creatAMarker(map, icon, point, id, name,comment,radius, html, true);
		  var markerData = new storeMarkerData(point, id, name, comment, radius, html);
		  gmarkersGloBal.push(marker);
		  markerDataArray.push(markerData);
		  side_bar_markers_html += '<tr><td><a href="javascript:myclickGmarkers(' + i + ')">' + name + '<\/a></tr></td>';
        }
		
		var side_bar_distance_html="";
		for(var i = 0; i < markerDataArray.length; i++){
			var marker = markerDataArray[i];
			for(var k = 0; k < locationDataArray.length; k++){
				var location = locationDataArray[k];
				var distance = if_gmap_getdistance(marker.point, location.point);
				if(parseFloat(distance) < parseFloat(marker.radius)){
					delete gmarkersLocationGloBal[k];
					var icon = customIcons["warningPassedLocation"] || {};
					var html = location.html + "<br><b>Trong vung nguy hiem</b>";
					var newLocation = new creatALocation(map, icon, location.point, html, true);
					gmarkersLocationGloBal[k] = newLocation;
					side_bar_distance_html += "LOCATION: " + location.id + "    DISTANCE = " + distance + " MARKER: " + marker.name + " ban kinh= " + marker.radius + "</br>";
				}
			}
		}

		// put the assembled side_bar_html contents into the side_bar div
		document.getElementById("tableListFreezePoint").innerHTML = side_bar_html;
		// put the assembled side_bar_markers contents into the side_bar_markers div
		document.getElementById("tableDangerArea").innerHTML = side_bar_markers_html;
		// put the assembled side_bar_distance contents into the side_bar_markers div
		//document.getElementById("side_bar_distance").innerHTML = side_bar_distance_html;

	  });	

}
	function storeLocationData(point, id, timeStamp, html){
		this.point = point;
		this.id = id;
		this.timeStamp = timeStamp;
		this.html = html;
	}
	function creatALocation(map, icon, point, html, visible) {
	  var location = new google.maps.Marker({
		map: map,
		icon: icon.icon,
		position: point
	  });
	  overlays.push(location);	
	  location.setVisible(visible);
	  bindInfoWindow(location, map, html)
	   return location;
    }
	function storeMarkerData(point, id, name, comment, radius, html){
		this.point = point;
		this.id = id;
		this.name = name;
		this.comment = comment;
		this.radius = radius;
		this.html = html;
	}
	
	function creatAMarker(map, icon, point, id, name, comment, radius, html, visible) {
      var circle = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: point,
            radius: radius*11/11
          };
      markerCircle = new google.maps.Circle(circle);
	  var marker = new google.maps.Marker({
		map: map,
		icon: icon.icon,
		position: point
	  });
	  overlays.push(marker);	
	  overlays.push(markerCircle);
	  marker.setVisible(visible);
	  bindInfoWindow(marker, map, html);
	  return marker;
    }
	  
	function bindInfoWindow(marker, map, html){
	var infoWindow = new google.maps.InfoWindow;
	 google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
	
	}
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
		  
        }
      };
	  
	  
      request.open('GET', url, true);
      request.send(null);
    }
	


    function doNothing() {}