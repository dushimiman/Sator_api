<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname ="my second database";


$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT m_device.PlateNo AS Plate_No, 
                m_device.serialnumber AS imei, 
                m_tracking.longitude, 
                m_tracking.latitude, 
                UNIX_TIMESTAMP(m_tracking.creationDate) AS timestamp, 
                m_tracking.speed AS velocity 
        FROM m_device 
        INNER JOIN m_tracking ON m_device.serialnumber = m_tracking.serialnumber";

$result = $conn->query($sql);
$examples = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $example = array(
            "Plate_No" => $row['Plate_No'],
            "imei" => $row['imei'],
            "longitude" => $row['longitude'],
            "latitude" => $row['latitude'],
            "timestamp" => $row['timestamp'],
            "velocity" => $row['velocity']
        );
        $examples[] = $example;
    }
}

$conn->close();

header('Content-Type: application/json');

echo json_encode($examples);
?>
