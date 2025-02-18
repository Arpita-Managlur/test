<?php
session_start();

// Include the database connection file
require_once 'db.php';

// Assuming the logged-in doctor's ID is stored in the session
$doctor_id = $_SESSION['doctor_id'] ?? 1; // Default to 1 for demonstration purposes

// Fetch appointments for the doctor
$stmt = $conn->prepare("
    SELECT a.id, u.name, a.appointment_date, a.appointment_time
    FROM appointments a
    INNER JOIN users u ON a.patient_id = u.id
    WHERE a.doctor_id = ?
    ORDER BY a.appointment_date, a.appointment_time
");

$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
} else {
    $appointments = [];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
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
            padding: 40px;
        }

        .content-header {
            margin-bottom: 20px;
            text-align: center;
        }

        .content-header h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        /* Appointments Table */
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 0px;
            overflow: hidden;
        }

        .appointments-table thead {
            background-color:black;
            color: white;
        }

        .appointments-table thead th {
            text-align: left;
            padding: 12px;
            font-size: 16px;
        }

        .appointments-table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .appointments-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .appointments-table tbody td {
            padding: 12px;
            font-size: 14px;
            color: #555;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .status.confirmed {
            color: green;
        }

        .status.pending {
            color: orange;
        }

        .status.canceled {
            color: red;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .appointments-table thead {
                display: none;
            }

            .appointments-table tbody tr {
                display: block;
                margin-bottom: 10px;
                border-bottom: none;
            }

            .appointments-table tbody td {
                display: block;
                text-align: right;
                padding: 10px 5px;
                border-bottom: 1px solid #ddd;
            }

            .appointments-table tbody td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                color: #333;
            }
        }
        
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Doctor Dashboard</h2>
        <a href="ddashbrd.php">Home</a>
        <a href="dprofile.php">Profile</a>
        <a href="dappointment.php" class="active">Appointments</a>
        <a href="dpatient.php">Patients</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Your Appointments</h1>
        </div>

        <?php if (!empty($appointments)): ?>
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Appointment id</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                        <td><?= htmlspecialchars($appointment['id']); ?></td>
                            <td><?= htmlspecialchars($appointment['name']); ?></td>
                            
                            <td><?= htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_time']); ?></td>
                            
                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
