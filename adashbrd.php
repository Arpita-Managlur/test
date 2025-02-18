
<?php
// Database connection details
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'doc';

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of doctors
$sql = "SELECT COUNT(*) AS total_doctors FROM doctors";
$result = $conn->query($sql);
$totalDoctors = $result->num_rows > 0 ? $result->fetch_assoc()['total_doctors'] : 0;



// Fetch additional details (e.g., specializations count)
$sqlSpecializations = "SELECT COUNT(DISTINCT specialization) AS total_specializations FROM doctors";
$resultSpecializations = $conn->query($sqlSpecializations);
$totalSpecializations = $resultSpecializations->num_rows > 0 ? $resultSpecializations->fetch_assoc()['total_specializations'] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            width: 73%;
            margin: 20px auto;
            padding: 20px;
            margin-left: 270px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }



    
        .sidebar a.active {
            background-color:  #0056b3;
        }


    
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color:   #191966;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px 0;
            font-size: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar ul li {
            margin: 0;
        }

        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 16px;
        }

        .sidebar ul li a:hover {
            background-color: #0056b3;
          
        }
        .container {
            width: 73%;
            margin: 20px auto;
            padding: 20px;
            margin-left: 270px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 40px;
        }
        .card {
            background-color: rgba(98, 91, 91, 0.1);
            color:black;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            font-size: 24px;
            margin: 0;
        }
        .card p {
            font-size: 18px;
            margin: 10px 0 0;
        }
        .card .number {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
      <!-- Sidebar -->
      <div class="sidebar">
        <div>
            <h2>Admin Dashboard</h2>
            <ul>
            <li> <a href="adashbrd.php" class="active">Home</a></li>
            <li><a href="aappointment.php">Manage Appointments</a></li>
                <li><a href="adoctor.php">Manage Doctors</a></li>
                <li><a href="areport.php" >View Patients Reports</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
      
    </div>

    <div class="container">
    <div class="dashboard">
        <!-- Total Doctors Card -->
        <div class="card">
            <h2>Total Doctors</h2>
            <p class="number"><?= $totalDoctors ?></p>
            <p>Number of registered doctors</p>
        </div>
        
        <!-- Total Specializations Card -->
        <div class="card">
            <h2>Total Specializations</h2>
            <p class="number"><?= $totalSpecializations ?></p>
            <p>Number of unique specializations</p>
        </div>

     
    </div>
       
    </div>
</body>
</html>









