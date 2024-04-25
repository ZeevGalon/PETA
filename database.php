<?php

// Create connection
$conn = new mysqli($database_host, $database_username, $database_password, $database_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}