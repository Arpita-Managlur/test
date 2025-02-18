<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "doc";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $age = $conn->real_escape_string($_POST['age']);
    $address = $conn->real_escape_string($_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Prepare SQL to insert data into the users table
    $sql = "INSERT INTO users (name, email, phone, gender, age, address, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiss", $name, $email, $phone, $gender, $age, $address, $password);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        // Use JavaScript for an alert and redirect
        echo "<script>
                alert('Sign up successful! You can now log in.');
                window.location.href = 'plogin.php'; // Redirect to login page
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error: Unable to sign up. Please try again.');
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
