<?php
// Database credentials
$host = 'sql213.infinityfree.com'; // Hostname (e.g., 'localhost' or '127.0.0.1')
$username = 'if0_38292942_doc';  // Your MySQL username
$password = 'LoGcSfzKMmyrAiC';      // Your MySQL password (default is empty for 'root' in some setups)
$dbname = 'if0_38292942_doc'; // The name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
