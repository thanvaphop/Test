<?php
include("db.php");
include("new.php");
?>
<html>
  <head>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>  -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--<link href="cssForHome.css" rel="stylesheet">-->
  <!--Leaflet Links-->
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script><!--
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-1.0.3/leaflet.css" />
	<script src="http://cdn.leafletjs.com/leaflet-1.0.3/leaflet.js"></script> -->
    <style>
      #map {
        height:800;
        width: 100%;
       }
	  #legend {
        font-family: Arial, sans-serif;
		background-color: #F0FFFF;
		background: rgba(240, 255, 255,0.9);
        padding: 10px;
        margin: 10px;
        border: 3px solid #F0FFFF;
        height: 60%;
	    width: 15%;
	    overflow: auto;
	    
		
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {
        vertical-align: middle;
      }
	  #valuesTable{
	background-color: #F0FFFF;
	background: rgba(240, 255, 255,0.7);
	position: fixed;
	left: 1%;
	top: 50px;
	height: 100%;
	margin: auto;
	max-width:17%;
	color: black;
	z-index: 1;
	overflow: auto;
}

#lastupdated{
	position: relative;
	left: 10px;
	font-size: 10px;
}

#locationheader{
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-style: bold;
	font-size: 25px;
	position: relative;
}
.values{
	font-size: 20px;
}
table{
	border-collapse:separate;
	border-spacing:0px 0px;
	font-style: bold;
}


table.table#temprh > tbody > tr > td {
	border: 0;
}
#temprh {
	padding-top: 10px;
	font-size: 12px;
}
.table>tbody>tr>td.pollutantName {
	border-top: 0px;

}

.table-condensed>tbody>tr>td {
	padding: 0.5px;
}

.table-condensed>tbody>tr>td.pollutantFull {
	padding-bottom: 5px;
	font-size: 10px;
}

.pollutantValue {
	text-align: right;

	
}

h4 {
	text-align: center;
}

    </style>
	
        	 <?php
                $api_key_value = "96322de1-eb12-4a7b-8bed-07b5e3e0d12c";
                $api_key= $CO = $AQI =$Date= $NO2 = $O3 = $FineParticles = $CourseParticles = $lat = $lng= $type=$Temp= $Hum = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
        		 
            $api_key = test_input($_POST["api_key"]);
        
            if($api_key == $api_key_value) {
        
                $AQI = test_input($_POST["AQI"]);
                $O3 = test_input($_POST["O3"]);
                $FineParticles = test_input($_POST["FineParticles"]);
                $CourseParticles = test_input($_POST["CourseParticles"]);
                $lat = test_input($_POST["lat"]);
                $lng = test_input($_POST["lng"]);
                $type = test_input($_POST["type"]);
                $Temp = test_input($_POST["Temp"]);
                $Hum = test_input($_POST["Hum"]);
                $Date = test_input($_POST["Date"]);
                
                // Create connection
                $connection = mysqli_connect('localhost','id16513288_admin','wR/oi2p[ghL8/U%H','id16513288_gases');
                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }       
                $sql = "INSERT INTO gases (AQI,O3, FineParticles, CourseParticles, lat, lng,type, Temp, Hum,Date) 
                VALUES ('" . $AQI . "', '" . $O3 . "', '" . $FineParticles . "', '" . $CourseParticles . "', '" . $lat . "', '" . $lng . "', '" . $type . "', '" . $Temp . "', '" . $Hum . "', '" . $Date . "')";
                
                if ($connection->query($sql) === TRUE) {
                    echo "New record created successfully";
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $connection->error;
                }
            
                $connection->close();
            }
            else {
               // echo "Wrong API Key provided.";
            }
        
        }
        else {
           // echo "No data posted with HTTP POST.";
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        toXML();
      ?>			
		
  </head>
  <body>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
 <div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	  <span class="sr-only">Toggle navigation</span>
	  <span class="icon-bar"></span>
	  </button>
	 </div>
  <div class="collapse navbar-collapse">
	  
  <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php" class="image_navbar"></a></li>
<li><a href="index.php"><font size=4" color="white"><b> Air Quality Management</b></font></a></li>
      <li class="active"><a href="index.php">Home</a></li>  
<li><a href="AQI101.html" rel="m_PageScroll2id">AQI101</a></li>
  </ul>
  <li><a href href="index.php"><img  src="logo.png" style="margin:0;"width="150" height="60 "></a></li>
    </div>
  </div>
  </div>


    <div id="map"></div>
	<div id="legend"><h3>ความหมายของสี</h3></div>
    <script>

	  var iconBase = 'https://maps.google.com/mapfiles/kml/pushpin/';
	  var icons={
	     a:{
		   icon:iconBase+'purple-pushpin.png',
		   name:'มีผลต่อสุขภาพ'
		 },
         b:{
		   icon:iconBase+'red-pushpin.png',
		   name:'เริ่มมีผลกระทบต่อสุขภาพ'
		 },
		  c:{
		   icon:iconBase+'ylw-pushpin.png',
		   name:'ปานกลาง'
		 },
		 d:{
		   icon:iconBase+'grn-pushpin.png',
		   name:'ดี'
		 },
		 e:{
		   icon:iconBase+'ltblu-pushpin.png',
		   name:'ดีมาก'
		 }
	  };
  
		function initMap() {
					   

		var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(13.754350,100.620453),
		  zoom: 15,
          mapTypeId: 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow;
         document.getElementById('locationheader').innerHTML ='Location';
				
				document.getElementById('aqib').innerHTML ='Blank';
				document.getElementById('o3b').innerHTML ='Blank';
				document.getElementById('Fineb').innerHTML ='Blank';
				document.getElementById('Courseb').innerHTML ='Blank';
				document.getElementById('dateb').innerHTML ='Blank';
				document.getElementById('tempb').innerHTML ='Blank';
				document.getElementById('humb').innerHTML ='Blank';
          // Change this depending on the name of your PHP or XML file
          downloadUrl('myxml.xml?id='+Math.random(), function(data) {
            var xml = data.responseXML;
            var gases= xml.getElementsByTagName('gas');
			var i=0;
            Array.prototype.forEach.call(gases, function(gasElem) {
              var AQI=parseInt(gases[i].getElementsByTagName("AQI")[0].childNodes[0].nodeValue);
			  var O3=parseFloat(gases[i].getElementsByTagName("O3")[0].childNodes[0].nodeValue);
			  var Fine= parseFloat(gases[i].getElementsByTagName("FineParticles")[0].childNodes[0].nodeValue);
			  var Course=parseFloat(gases[i].getElementsByTagName("CourseParticles")[0].childNodes[0].nodeValue);
			  var Temp=parseFloat(gases[i].getElementsByTagName("Temp")[0].childNodes[0].nodeValue);
			  var Hum= parseFloat(gases[i].getElementsByTagName("Hum")[0].childNodes[0].nodeValue);
              var type = gases[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
			  var dateT = gases[i].getElementsByTagName("Date")[0].childNodes[0].nodeValue;
              var point = new google.maps.LatLng(
                  parseFloat(gases[i].getElementsByTagName("lat")[0].childNodes[0].nodeValue),
                  parseFloat(gases[i].getElementsByTagName("lng")[0].childNodes[0].nodeValue));

				 
			  var avg=AQI;
			  console.log(avg);
			  if(avg>0) console.log("Hi");
              i++;
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = type;
              var text = document.createElement('h4');
              text.textContent ='AQI:'+avg;
			  var text200 = document.createElement('h4');
			  text200.textContent ='AQI:มากกว่า 200';	
			  var text2 = document.createElement('h6');
              text2.textContent ='อัพเดตเมื่อ :'+dateT;
			  var x;
			  if(avg>=201){
			    
              infowincontent.appendChild(strong);
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
				
			  var image1 =document.createElement('img');
			  image1.src="Purple.png";
			  image1.style="display:block;margin-left: auto;margin-right: auto;"
			  infowincontent.appendChild(image1);
			  infowincontent.appendChild(document.createElement('br')); 
				 
			  infowincontent.appendChild(text200);
			  infowincontent.appendChild(document.createElement('il'));

              infowincontent.appendChild(text2);
			  infowincontent.appendChild(document.createElement('br'));
				  x='a';
				 }
			else if(avg>=101&&avg<201){

              infowincontent.appendChild(strong);
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));

			  var image2 =document.createElement('img');
			  image2.src="Red.png";
			  image2.style="display:block;margin-left: auto;margin-right: auto;"
			  infowincontent.appendChild(image2);
			  infowincontent.appendChild(document.createElement('br')); 

			  infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('il'));

              infowincontent.appendChild(text2);
			  infowincontent.appendChild(document.createElement('br'));
				  x='b';
				 }
			else if(avg>=51&&avg<101) {

			  infowincontent.appendChild(strong);
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));

			  var image3 =document.createElement('img');
			  image3.src="Yellow.png";
			  image3.style="display:block;margin-left: auto;margin-right: auto;"
			  infowincontent.appendChild(image3);
			  infowincontent.appendChild(document.createElement('br')); 

			  infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('il'));

              infowincontent.appendChild(text2);
			  infowincontent.appendChild(document.createElement('br'));
				x='c';
				}
			else if(avg>=26&&avg<51) {
			  infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
              infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  var image4 =document.createElement('img');
			  image4.src="Green.png";
			  image4.style="display:block;margin-left: auto;margin-right: auto;"
			  infowincontent.appendChild(image4);
			  infowincontent.appendChild(document.createElement('br')); 

			  infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('il'));

              infowincontent.appendChild(text2);
			  infowincontent.appendChild(document.createElement('br'));
				x='d'; 
				}
			else {
			  infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  infowincontent.appendChild(document.createElement('br'));
			  var image5 =document.createElement('img');
			  image5.src="Blue.png";
			  image5.style="display:block;margin-left: auto;margin-right: auto;"
			  infowincontent.appendChild(image5);
			  infowincontent.appendChild(document.createElement('il'));
			  infowincontent.appendChild(text);
			  infowincontent.appendChild(document.createElement('il'));

              infowincontent.appendChild(text2);
			  infowincontent.appendChild(document.createElement('br'));
				 x='e';
				}

			  
              var marker =0;
             
              marker= new google.maps.Marker({
                map: map,
                position: point,
				icon: icons[x].icon
              });
              
              
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
				document.getElementById('locationheader').innerHTML =type;
				if(avg>=200){document.getElementById('aqib').innerHTML ='มากกว่า200';}else {document.getElementById('aqib').innerHTML =AQI;}
				document.getElementById('o3b').innerHTML =O3;
				document.getElementById('Fineb').innerHTML =Fine;
				document.getElementById('Courseb').innerHTML =Course;
				document.getElementById('dateb').innerHTML =dateT;
				document.getElementById('tempb').innerHTML =Temp;
				document.getElementById('humb').innerHTML =Hum;
              });
            });
          });
        var legend = document.getElementById('legend');
        for (var key in icons) {
          var type = icons[key];
          var name = type.name;
		  console.log(name);
          var icon = type.icon;
          var div = document.createElement('div');
          div.innerHTML = '<img src="' + icon + '"> ' + name;
          legend.appendChild(div);
        }

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
        }

        function openIW(layerEvt) {
  if (layerEvt.row) {
    var content = layerEvt.row['admin'].value;
  } else if (layerEvt.featureData) {
    var content = layerEvt.featureData.name;
  }
  document.getElementById('locationheader').innerHTML =content;
  document.getElementById('aqib').innerHTML =content;
  document.getElementById('o3b').innerHTML =content;
  document.getElementById('tempb').innerHTML =content;
  document.getElementById('humb').innerHTML =content;
				document.getElementById('Fineb').innerHTML =content;
				document.getElementById('Courseb').innerHTML =content;
				document.getElementById('dateb').innerHTML =content;
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
	  
	

    </script>
	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6wAa9OYZjUFgisXP6vIez963OflUcq2Q&callback=initMap">
    </script>

	<!-- MAP SECTION -->
<!--<div id="map"> -->
	<div>

		<div class="col-md-3" id="valuesTable">

		<div class="col-md-3" id="valuesTable" style="padding-top: 24px;">

			<div id="locationheader"></div>
			<!--<div id="lastupdated">Last Updated</div>-->

			<table class="table table-condensed" id="pollutants" style="padding-top: 20px">
			<tr>
				<td id="Coursea" class="pollutantName values" style="color:black";>PM 2.5</td>
				<td id="Courseb" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>	
			<tr>
				<td class="pollutantFull" style="color:black";>ug/m<sup>3</sup></td>
				<td class="unitlabel" style="color:black";></td>
                </tr>
			<tr>
				<td id="Finea" class="pollutantName values" style="color:black";>PM 10</td>
				<td id="Fineb" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>	
			<tr>
				<td class="pollutantFull" style="color:black";>ug/m<sup>3</sup></td>
				<td class="unitlabel" style="color:black";></td>
			</tr>

			<tr>
				<td id="o3a" class="pollutantName values" style="color:black";>O3</td>
				<td id="o3b" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>	
			<tr>
				<td class="pollutantFull" style="color:black";>ppb</td>
				<td class="unitlabel" style="color:black";></td>
			</tr>

			<tr>
				<td id="tempa" class="pollutantName values" style="color:black";>Temp</td>
				<td id="tempb" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>	
			<tr>
				<td class="pollutantFull" style="color:black";>celsius</td>
				<td class="unitlabel" style="color:black";></td>
			</tr>


			<tr>
				<td id="huma" class="pollutantName values" style="color:black";>Hum</td>
				<td id="humb" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>	
			<tr>
				<td class="pollutantFull" style="color:black";>percent</td>
				<td class="unitlabel" style="color:black";></td>
			</tr>

			<tr>
			<td id="aqia" class="pollutantName values" style="color:black";>AQI</td>
				<td id="aqib" class="alpha2 pollutantName pollutantValue values" style="color:black";></td>
			</tr>

			<tr>
				<td class="pollutantFull" style="color:black";>Air Quality Index</td>
				<td class="unitlabel" style="color:black";></td>
				
			</tr>


			<tr>
			<td id="datea" class="pollutantName values" style="color:black";>Date</td>
				<td id="dateb" class="alpha1 pollutantName pollutantValue values" style="color:black";></td>
			</tr>
			<tr>
				<td class="pollutantFull" style="color:black";>updated</td>
				<td class="unitlabel" style="color:black";></td>
				
			</tr>
			</table>
			<div>
				<p style="font-size: 15px; margin-top: 30px">กดรูป pin บน map เพื่อดูข้อมูล</p>
				<p style="font-size: 12px; margin-bottom: 55px">Note:ค่าการวัดอัพเดตทุกๆ 1 ชั่วโมง</p>
			</div>
			</div>
		<!--	</div>   -->
			
  </body>
</html>