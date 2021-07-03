<!DOCTYPE html>
<html><body>
<?php
$servername = "localhost";
$username="id16513288_admin";
$password="wR/oi2p[ghL8/U%H";
$dbname="id16513288_gases";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, AQI,  O3 FROM gases ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>id</td> 
        <td>AQI</td> 
        <td>O3</td>
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_AQI = $row["AQI"];
        $row_O3 = $row["O3"]; 
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_AQI . '</td> 
                <td>' . $row_O3 . '</td>

              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>