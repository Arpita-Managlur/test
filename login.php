<?php
session_start();

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

// Initialize error variable
$error = "";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize user inputs
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Don't sanitize; needed for password_verify()

    // Query to check if the username exists
    $sql = "SELECT * FROM users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];

            // Redirect to the patient dashboard
            header("Location: pdashbrd.php");
            exit;
        } else {
            // Invalid password, set error
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: plogin.php");
            exit;
        }
    } else {
        // Invalid username, set error
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: plogin.php");
        exit;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
