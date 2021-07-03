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
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>	