<?php
// Start a session to access session variables
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: plogin.php");
    exit;
}

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
            background: url('b.jpg'); 
            background-size: cover;
            background-position: center;
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
        .header h1 {
            font-size: 20px;
        }
      
     
        p{
            font-size: 25px;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card h3 {
            margin-bottom: 10px;
        }

        /* Hospital Photos and Names */
        .hospital-gallery {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .hospital-card {
            width: 310px;
            
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
        }
        .hospital-card img {
            width: 100%;
            border-radius: 8px;
            height: 250px;
            object-fit: cover;
        }
        .hospital-card h4 {
            margin-top: 10px;
            font-size: 1.1rem;
        }


    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="pdashbrd.php" class="active">Home</a>
        <a href="pprofile.php">Profile</a>
        <a href="viewdoctor.php">Doctors</a>
        <a href="pbook.php">Book Appointment</a>
        <a href="phistory.php">Appointment History</a>
        <a href="pdelete.php">Delete Appointment</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="header">
            <h1>Your Health, Our Priority - Book with Ease </h1> 
            
        </div>
        <br>
        <br>

        
        <br>
        <br>

        <!-- Hospital Gallery Section -->
        <div class="hospital-gallery">
            <div class="hospital-card">
                <img src="img/hos1.avif" alt="Hospital 1">
                <h4></h4>
            </div>
            <div class="hospital-card">
                <img src="img/hos2.jpg" alt="Hospital 2">
                <h4></h4>
            </div>
            <div class="hospital-card">
                <img src="img/hos3.webp" alt="Hospital 3">
                <h4></h4>
            </div>
            <!-- Add more hospitals as needed -->
        </div><br><br>
        <div class="quote-section">
            <p>"The good physician treats the disease; the great physician treats the patient who has the disease."</p>
        </div>
    </div>
       
</body>
</html>
