<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'doc');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointments for the selected date
$appointments = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_reports'])) {
    $selected_date = $_POST['appointment_date'];

    $query = "SELECT 
                a.id AS appointment_id, 
                a.appointment_date, 
                a.appointment_time, 
                p.name AS patient_name, 
                d.name AS doctor_name
               
              FROM appointments a
              JOIN users p ON a.patient_id = p.id
              JOIN doctors d ON a.doctor_id = d.id
              WHERE a.appointment_date = '$selected_date'";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $message = "No appointments found for the selected date.";
    }
}
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

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="date"] {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .sidebar a.active {
            background-color:  #0056b3;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: black;
            color: #fff;
        }

        .no-data {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #555;
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
    </style>
</head>
<body>
      <!-- Sidebar -->
      <div class="sidebar">
        <div>
            <h2>Admin Dashboard</h2>
            <ul>
            <li> <a href="adashbrd.php" >Home</a></li>
            <li><a href="adashbrd.php">Manage Appointments</a></li>
                <li><a href="adoctor.php">Manage Doctors</a></li>
                <li><a href="areport.php" class="active">View Patients Reports</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
      
    </div>

<div class="container">
    <h1>View Patient Reports</h1>

    <!-- Date Selection Form -->
    <form method="POST">
        <input type="date" name="appointment_date" required>
        <button type="submit" name="view_reports">View Reports</button>
    </form>

    <!-- Display Appointments -->
    <?php if (!empty($appointments)): ?>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo $appointment['appointment_id']; ?></td>
                        <td><?php echo $appointment['appointment_date']; ?></td>
                        <td><?php echo $appointment['appointment_time']; ?></td>
                        <td><?php echo $appointment['patient_name']; ?></td>
                        <td><?php echo $appointment['doctor_name']; ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($message)): ?>
        <p class="no-data"><?php echo $message; ?></p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
