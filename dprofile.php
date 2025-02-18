<?php
session_start();

// Include the database connection file
require_once 'db.php';

// Assuming the logged-in doctor's ID is stored in the session
$doctor_id = $_SESSION['doctor_id'] ?? 1; // Default to 1 for demonstration purposes

// Fetch doctor details
$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $doctor = $result->fetch_assoc();
} else {
    echo "Doctor profile not found.";
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 15px 20px;
            display: block;
            border-bottom: 1px solid #34495e;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .sidebar a.active {
            background-color:#007bff;
        }
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            display: flex;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 70%;
            max-width: 900px;
        }

        /* Profile Image */
        .profile-image {
            width: 40%;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .profile-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Profile Details */
        .profile-details {
            width: 60%;
            padding: 20px;
        }

        .profile-details h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .profile-details p {
            margin: 10px 0;
            color: #555;
        }

        .profile-details p span {
            font-weight: bold;
            color: #000;
        }

        .profile-details .bio {
            margin-top: 20px;
            
            color: black;
        }
        .sidebar a.active {
            background-color:  #007bff;
        }

        .header {
            background-color: #fff;
            padding: 20px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Doctor Dashboard</h2>
        <a href="ddashbrd.php"> Home</a>
        <a href="dprofile.php" class="active"> Profile</a>
        <a href="dappointment.php"> Appointments</a>
        <a href="dpatient.php"> Patients</a>
        <a href="index.php"> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
       
        <div class="profile-container">
            <!-- Left: Profile Image -->
            <div class="profile-image">
                <img src="img/dou.png" alt="Doctor's Profile Picture">
            </div>

            <!-- Right: Profile Details -->
            <div class="profile-details">
                <h2><?= htmlspecialchars($doctor['name']); ?></h2>
                <p><span>Email: </span> <?= htmlspecialchars($doctor['email']); ?></p>
                <p><span>Phone: </span> <?= htmlspecialchars($doctor['phone']); ?></p>
                <p><span>Experience: </span> <?= htmlspecialchars($doctor['experience']); ?> years</p>
                <p><span>Specialization: </span> <?= htmlspecialchars($doctor['specialization']); ?></p>
                <p class="bio"><span>Biography: </span><?= htmlspecialchars($doctor['biography']); ?></p>
                <p class="bio"><span>Education: </span> <?= htmlspecialchars($doctor['education']); ?></p>
            </div>
        </div>
    </div>

</body>
</html>
