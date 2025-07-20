<?php
$host = '<dbserver-ip>'; 
$user = 'app_user';
$password = 'app_password';

$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
echo " Connected successfully to MySQL!";

?>
