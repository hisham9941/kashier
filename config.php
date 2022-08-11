<?php
// $servername = "127.0.0.1:8889";
$servername = ")1SBK#YOu!k9";
$username = "root";
$password = "root";

$connection;
try {
  $conn = new PDO("mysql:host=$servername;dbname=kashier_new", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
  $connection = 1;
} catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
  $connection = 0;
}
?>