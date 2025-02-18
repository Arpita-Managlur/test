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

// Initialize variables
$specializations = [];
$doctors = [];
$doctorDetails = null;
$selectedSpecialization = '';
$selectedDoctorId = null;

// Fetch specializations
$sql = "SELECT DISTINCT specialization FROM doctors";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $specializations[] = $row['specialization'];
    }
}

// Fetch doctors if a specialization is selected
if (isset($_GET['specialization'])) {
    $selectedSpecialization = $_GET['specialization'];
    $stmt = $conn->prepare("SELECT id, name FROM doctors WHERE specialization = ?");
    $stmt->bind_param("s", $selectedSpecialization);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }
    }
}

// Fetch doctor details if a doctor is selected
if (isset($_GET['doctor_id'])) {
    $selectedDoctorId = $_GET['doctor_id'];
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $selectedDoctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $doctorDetails = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Specializations</title>
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
        .main-content {
            margin-left: 270px;
            padding: 20px;
            width: 80%;
        }
        h1 {
            font-size: 32px;
            color: #191966;
        }
        .main-content h2 {
            font-size: 24px;
            color: #7070db;
            margin-top: 20px;
        }
        .specialization-list, .doctor-list {
            list-style-type: none;
            padding: 0;
        }
        .specialization-list li, .doctor-list li {
            margin: 10px 0;
        }
        .specialization-list a, .doctor-list a {
            text-decoration: none;
            color: #191966;
            font-size: 20px;
            font-weight: bold;
        }
        .specialization-list a:hover, .doctor-list a:hover {
            color: #7070db;
        }
        .doctor-details {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .doctor-details img {
            width: 150px;
            border-radius: 50%;
        }
        .doctor-details h3 {
            font-size: 28px;
            color: #191966;
        }
        .doctor-details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .doctor-details strong {
            color: #191966;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="pdashbrd.php">Home</a>
        <a href="pprofile.php" >Profile</a>
        <a href="viewdoctor.php" class="active">Doctors</a>
        <a href="pbook.php">Book Appointment</a>
        <a href="phistory.php">Appointment History</a>
        <a href="pdelete.php">Delete Appointment</a>
        <a href="index.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Doctor Specializations</h1>

        <!-- Specializations List -->
        <h2>Available Specializations</h2>
        <ul class="specialization-list">
            <?php foreach ($specializations as $specialization): ?>
                <li>
                    <a href="?specialization=<?= urlencode($specialization) ?>">
                        <?= htmlspecialchars($specialization) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($selectedSpecialization): ?>
            <h2>Doctors specializing in "<?= htmlspecialchars($selectedSpecialization) ?>"</h2>
            <ul class="doctor-list">
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <li>
                            <a href="?specialization=<?= urlencode($selectedSpecialization) ?>&doctor_id=<?= $doctor['id'] ?>">
                                <?= htmlspecialchars($doctor['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No doctors found for this specialization.</li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>

        <?php if ($doctorDetails): ?>
            <div class="doctor-details">
                <h3>Details of Dr. <?= htmlspecialchars($doctorDetails['name']) ?></h3>
                
                <p><strong>Specialization:</strong> <?= htmlspecialchars($doctorDetails['specialization']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($doctorDetails['email']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($doctorDetails['phone']) ?></p>
                <p><strong>Education:</strong> <?= htmlspecialchars($doctorDetails['education']) ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars($doctorDetails['experience']) ?> years</p>
                <p><strong>Biography:</strong> <?= htmlspecialchars($doctorDetails['biography']) ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
