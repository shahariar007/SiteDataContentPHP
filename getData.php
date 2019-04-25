<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password,"travel_tracker");
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

$temp=array();
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      array_push($temp,$row);
    }
} else {
    echo "0 results";
}
echo json_encode($temp);
mysqli_close($conn);
?>