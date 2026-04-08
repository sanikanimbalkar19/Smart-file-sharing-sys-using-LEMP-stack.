
<?php
$conn = new mysqli("localhost", "secureuser", "proj@secure1234", "fileshare");
if ($conn->connect_error) {
    die("Connection failed :" . $conn->connect_error);
}
?>
