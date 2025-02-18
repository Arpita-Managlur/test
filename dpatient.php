<?php
session_start();

// Include the database connection file
require_once 'db.php';

// Assuming the logged-in doctor's ID is stored in the session
$doctor_id = $_SESSION['doctor_id'] ?? 1; // Default to 1 for demonstration purposes

// Fetch patients for the doctor
$stmt = $conn->prepare("
    SELECT p.id, p.name, p.email, p.phone, p.age, p.gender, p.address 
    FROM users p
    JOIN appointments a ON p.id = a.patient_id
    WHERE a.doctor_id = ?
    GROUP BY p.id
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    $patients = [];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Patients</title>
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
            background-color:   #007bff;
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

        /* Patients Table */
        .patients-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .patients-table thead {
            background: black;
            color: white;
        }

        .patients-table thead th {
            text-align: left;
            padding: 12px;
            font-size: 16px;
        }

        .patients-table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .patients-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .patients-table tbody td {
            padding: 12px;
            font-size: 14px;
            color: #555;
        }

        .patients-table tbody td:last-child {
            text-align: center;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .patients-table thead {
                display: none;
            }

            .patients-table tbody tr {
                display: block;
                margin-bottom: 10px;
                border-bottom: none;
            }

            .patients-table tbody td {
                display: block;
                text-align: right;
                padding: 10px 5px;
                border-bottom: 1px solid #ddd;
            }

            .patients-table tbody td::before {
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
        <a href="dappointment.php">Appointments</a>
        <a href="dpatient.php" class="active">Patients</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Your Patients</h1>
        </div>

        <?php if (!empty($patients)): ?>
            <table class="patients-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                        <td><?= htmlspecialchars($patient['id']); ?></td>
                            <td><?= htmlspecialchars($patient['name']); ?></td>
                            <td><?= htmlspecialchars($patient['email']); ?></td>
                            <td><?= htmlspecialchars($patient['phone']); ?></td>
                            <td><?= htmlspecialchars($patient['age']); ?></td>
                            <td><?= htmlspecialchars($patient['gender']); ?></td>
                            <td><?= htmlspecialchars($patient['address']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No patients found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
