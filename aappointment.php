<?php
// Connect to the database
$conn = new mysqli('', 'root', '', 'doc');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $appointmentId = $_POST['appointment_id'];
    $query = "DELETE FROM appointments WHERE id='$appointmentId'";
    $conn->query($query);
}

// Fetch all appointments with patient and doctor names
$query = "
    SELECT 
        a.id, 
        u.name AS patient_name, 
        d.name AS doctor_name, 
        a.appointment_date,
        a.appointment_time
    FROM 
        appointments a
    JOIN 
        users u ON a.patient_id = u.id
    JOIN 
        doctors d ON a.doctor_id = d.id
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color:  #191966;
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

      

        /* Main Content Styles */
        .container {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            background-color: #dc3545;
            color: #fff;
        }
        .sidebar a.active {
            background-color:  #0056b3;
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
            <li><a href="adashbrd.php" class="active">Manage Appointments</a></li>
                <li><a href="adoctor.php">Manage Doctors</a></li>
                <li><a href="areport.php">View Patients Reports</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
      
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1>Manage Appointments</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['patient_name']; ?></td>
                        <td><?php echo $row['doctor_name']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['appointment_time']; ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                <button class="btn" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
