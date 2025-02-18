<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: dlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Sidebar styles */
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

        /* Content styles */
        .content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        .header {
            background-color: #ecf0f1;
            padding: 2px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px 0;
        }
       
        .sidebar a.active {
            background-color:  #007bff;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Doctor Dashboard</h2>
        <a href="ddashbrd.php" class="active"> Home </a>
        <a href="dprofile.php"> Profile</a>
        <a href="dappointment.php"> Appointments</a>
        <a href="dpatient.php"> Patients</a>
        <a href="index.php"> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <h1>Welcome, Dr. <?= htmlspecialchars($_SESSION['doctor_name']); ?>!</h1>
        </div>

        <div class="card">
            <h2>Today's Appointments</h2>
            <p>You have 5 appointments scheduled for today.</p>
        </div>

        <div class="card">
            <h2>New Messages</h2>
            <p>You have 2 unread messages.</p>
        </div>

        <div class="card">
            <h2>Patient Records</h2>
            <p>Access patient details and medical history.</p>
        </div>
    </div>

</body>
</html>
