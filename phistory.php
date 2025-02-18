<?php
// Database connection
$servername = "localhost"; // your database server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "doc"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the patient's appointment history
$patient_id = 1; // Example patient ID; you would typically fetch this from the session or another input
$sql =  "SELECT a.patient_id,a.id, a.doctor_id, d.name, a.appointment_date, a.appointment_time, d.specialization 
FROM appointments a, users u, doctors d
WHERE u.id= a.patient_id AND a.doctor_id= d.id 
ORDER BY a.appointment_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
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
            padding: 10px 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            margin-top: 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff; /* Shared background color for both sections */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
           
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="pdashbrd.php" >Home</a>
        <a href="pprofile.php" >Profile</a>
        <a href="viewdoctor.php">Doctors</a>
        <a href="pbook.php">Book Appointment</a>
        <a href="phistory.php" class="active">Appointment History</a>
        <a href="pdelete.php">Delete Appointment</a>
        <a href="index.php">Logout</a>
    </div>

    <div class="content">
        <!-- Header -->
        <div class="header">
            <h1>Patient's Appointment History</h1>
           
        </div>
        <br><br>

        <div class="container">

    
    <table>
        <thead>
            <tr>
            <th>Patient ID</th>
                <th>Appointment ID</th>
                <th>Doctor ID</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Specialization</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['patient_id'] . "</td>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['doctor_id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['appointment_date'] . "</td>";
                    echo "<td>" . $row['appointment_time'] . "</td>";
                    echo "<td>" . $row['specialization'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments found</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
