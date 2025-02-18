<?php
// Start the session
session_start();

// Include the database connection file
require_once 'db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: plogin.php");
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Fetch the patient details from the database
$sql = "SELECT * FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the user's data
    $patient = $result->fetch_assoc();
} else {
    // If no user is found, redirect to the dashboard or login
    echo "User not found.";
    exit;
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #f4f7fa;
            color: #333;
           
        }
        .sidebar {
            width: 250px;
            background-color: #191966;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 22px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            width: 90%;
            text-align: center;
            border-radius: 5px;
            display: block;
            font-weight: bold;
        }
        .sidebar a:hover {
            background-color: #7070db;
        }
        .sidebar a.active {
            background-color: #7070db;
        }
    
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 10px;
        }
        .header {
            background-color: #fff;
            padding: 20px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            margin-top: 20px;
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff; /* Shared background color for both sections */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          
        }
        .profile-image {
            flex: 1;
            text-align: center;
            padding-right:  20px;
            border-radius: 10px;
        }
        .profile-image img {
            width: 220px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #f4f7fa; /* Match the background color */
        }
        .profile-details {
            flex: 2;
            padding: 20px;
            background-color: #f4f7fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-details h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .profile-details p {
            font-size: 16px;
            margin: 10px 0;
            color: #555;
        }
        .back-button {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #004d99;
        }
        .header h1 {
            font-size: 20px;
        }
       
       
  
        .p{
         color: black;
        }
        

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="pdashbrd.php" >Home</a>
        <a href="pprofile.php" class="active">Profile</a>
        <a href="viewdoctor.php">Doctors</a>
        <a href="pbook.php">Book Appointment</a>
        <a href="phistory.php">Appointment History</a>
        <a href="pdelete.php">Delete Appointment</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <div class="header">
            <h1>Every profile tells a unique story. Here's yours.</h1>
            
        </div>
        <br><br>

        <div class="container">
            <!-- Profile Image -->
            <div class="profile-image">
                <img src="img/any1.jpg" alt="Profile Image">
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <h2>Patient Profile</h2>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($patient['phone']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></p>

                
            </div>
        </div>
    </div>
</body>
</html>
