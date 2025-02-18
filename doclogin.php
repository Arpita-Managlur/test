<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "doc";
$username = "root";
$password = ""; // Database password (leave empty for XAMPP)

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Prepare SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the doctor's details
        $doctor = $result->fetch_assoc();

        // Direct password comparison (for plain text passwords)
        if ($password === $doctor['password']) {
            // Password is correct, set session variables
            $_SESSION['doctor_logged_in'] = true;
            $_SESSION['doctor_id'] = $doctor['id']; // Store the doctor ID
            $_SESSION['doctor_name'] = $doctor['name']; // Store the doctor's name

            // Redirect to the dashboard
            header("Location: ddashbrd.php");
            exit();
        } else {
            // Password incorrect
            $error = "Invalid name or password.";
            header("Location: login.php?error=" . urlencode($error));
            exit();
        }
    } else {
        // Doctor not found
        $error = "Invalid name or password.";
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
