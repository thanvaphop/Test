<?php
require("phpsqlajax_dbinfo.php");

$dom = new DOMDocument("1.0");
$node = $dom->createElement("gases");
$parnode = $dom->appendChild($node);

$connection = mysqli_connect('localhost', 'id16513288_admin', 'wR/oi2p[ghL8/U%H','id16513288_gases');
if ($connection->connect_error) {  
  die('Not connected : ' . $connection->connect_error);
}

function toXML(){
	$data_txt=null;
    $myFile = "myxml.xml";
    $fh = fopen($myFile, 'w') or die("can't open file");
    $data_txt .= '<?xml version="1.0" encoding="utf-8"?>';
    $data_txt .= '<gases>';

    $connection = mysqli_connect('localhost', 'id16513288_admin', 'wR/oi2p[ghL8/U%H','id16513288_gases');
    $query = mysqli_query($connection,"SELECT * FROM gases");
    while($values_query = mysqli_fetch_assoc($query))
    {
        $data_txt .= '<gas>';
        $data_txt .= '<AQI>' .$values_query['AQI']. '</AQI>';
		$data_txt .= '<O3>' .$values_query['O3']. '</O3>';
		$data_txt .= '<FineParticles>' .$values_query['FineParticles']. '</FineParticles>';
		$data_txt .= '<CourseParticles>' .$values_query['CourseParticles']. '</CourseParticles>';
		$data_txt .= '<lat>' .$values_query['lat']. '</lat>';
		$data_txt .= '<lng>' .$values_query['lng']. '</lng>';
		$data_txt .= '<type>' .$values_query['type']. '</type>';
        $data_txt .= '<Date>' .$values_query['Date']. '</Date>';
        $data_txt .= '<Temp>' .$values_query['Temp']. '</Temp>';
        $data_txt .= '<Hum>' .$values_query['Hum']. '</Hum>';
        $data_txt .= '</gas>';
        
    }
    $data_txt .= '</gases>';
    fwrite($fh, $data_txt);
    fclose($fh);
}
?>