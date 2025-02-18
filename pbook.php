<?php
// Database connection setup
$host = 'localhost';
$dbname = 'doc';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialize variables
$doctors = [];
$booked_times = [];
$appointment_date = '';
$doctor_id = '';
$appointment_time = '';

// Start session to fetch logged-in user's ID
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}
$patient_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

// Fetch doctors based on specialization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['specialization'])) {
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("SELECT * FROM doctors WHERE specialization = :specialization");
    $stmt->bindParam(':specialization', $specialization);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch booked time slots for a specific doctor and date
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_date']) && isset($_POST['doctor_id'])) {
    $appointment_date = $_POST['appointment_date'];
    $doctor_id = $_POST['doctor_id'];

    // Validate that the selected date is not in the past
    $today = date('Y-m-d');
    if ($appointment_date < $today) {
        echo "<script>alert('Error: Appointment date cannot be in the past. Please select a valid date.');</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE doctor_id = :doctor_id AND appointment_date = :appointment_date");
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->execute();
    $booked_times = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Ensure booked times are in the correct format (HH:MM)
    $booked_times = array_map(function ($time) {
        return substr($time, 0, 5); // Trim the seconds part (HH:MM)
    }, $booked_times);
}

// Handle appointment booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_time'])) {
    $appointment_date = $_POST['appointment_date'];

    // Validate that the selected date is not in the past
    $today = date('Y-m-d');
    if ($appointment_date < $today) {
        echo "<script>alert('Error: Appointment date cannot be in the past. Please select a valid date.');</script>";
        exit;
    }

    $appointment_time = $_POST['appointment_time'];
    $doctor_id = $_POST['doctor_id'];

    // Validate that the patient ID exists in the users table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE id = :patient_id");
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        die("Error: Invalid patient ID.");
    }

    // Insert the appointment
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time)
                            VALUES (:patient_id, :doctor_id, :appointment_date, :appointment_time)");
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);

    if ($stmt->execute()) {
        $appointment_id = $conn->lastInsertId();

        // Escape the success message
        $success_message = "Appointment booked successfully!\n\n" .
            "Patient ID: $patient_id\n" .
            "Date: $appointment_date\n" .
            "Time: $appointment_time\n" .
            "Appointment ID: $appointment_id";

        // Encode the message for JavaScript
        $success_message = json_encode($success_message); // Safely encode message for JavaScript
        echo "<script>alert($success_message);</script>";
    } else {
        echo "<script>alert('Error booking appointment. Please try again later.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
          
        }
       
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .sidebar a:hover, .sidebar a.active {
            background-color: #7070db;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        
        .form-group input, .form-group select {
            width: 100%;
           
            font-size: 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            .form-group select {
   
    padding: 12px 16px; /* Increase padding to make it bigger */
    font-size: 18px;  /* Increase font size for better visibility */
    border: 1px solid #ccc;
    border-radius: 4px;
    
}

        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .time-slot {
            display: inline-block;
            margin: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            background-color: #f0f0f0;
            transition: background-color 0.3s;
        }
        .booked {
            background-color: red;
            color: white;
            cursor: not-allowed;
        }
        .booked:hover {
            background-color: red;
        }
        .selected {
            background-color: green;
            color: white;
        }
        .time-slot:hover:not(.booked) {
            background-color: lightgreen;
        }
        .break {
        background-color: #ffcc00;
        color: black;
        cursor: not-allowed;
        text-align: center;
        }
        .reports {
        background-color:#ffff00;
        color: black;
        cursor: not-allowed;
        text-align: center;
        }
        .header h1 {
            font-size: 25px;
        }
        .header {
            background-color: #fff;
            padding: 20px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

.break:hover {
    background-color: #ffcc00;
}
    </style>
    <script>
        function selectTime(slot) {
            // Remove 'selected' class from all slots
            document.querySelectorAll('.time-slot').forEach(element => {
                element.classList.remove('selected');
            });
            // If the slot is not booked, add 'selected' class
            if (!slot.classList.contains('booked')) {
                slot.classList.add('selected');
                document.getElementById('appointment_time').value = slot.dataset.time;
            }
        }
    </script>
</head>
<body>

<div class="sidebar">
    <h2>Patient Dashboard</h2>
    <a href="pdashbrd.php">Home</a>
    <a href="pprofile.php">Profile</a>
    <a href="viewdoctor.php">Doctors</a>
    <a href="pbook.php" class="active">Book Appointment</a>
    <a href="phistory.php">Appointment History</a>
    <a href="pdelete.php">Delete Appointment</a>
    <a href="index.php">Logout</a>
</div> 

<div class="content">
<div class="header">
    <h1>Book Appointment</h1>
</div>
<br><br>

    <!-- Select Specialization -->
    <h2>Select Specialization</h2>
    <br>
    <form action="" method="post">
        <label for="specialization">Specialization:</label>
        <select name="specialization" id="specialization">
            <option value="Cardiology">Cardiology</option>
            <option value="Dermatology">Dermatology</option>
            <option value="Pediatrics">Pediatrics</option>
        </select>
        <button type="submit">Find Doctors</button>
    </form>

    <!-- Display Doctors List -->
    <?php if ($doctors): ?>
        <h2>Select Doctor</h2>
        <form action="" method="post">
            <label for="doctor_id">Doctor:</label>
            <select name="doctor_id" id="doctor_id">
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?> (<?= $doctor['specialization'] ?>)</option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <label for="appointment_date">Appointment Date:</label>
            <input 
    type="date" 
    id="appointment_date" 
    name="appointment_date" 
    required 
    min="<?php echo date('Y-m-d'); ?>" 
    value="<?php echo htmlspecialchars($_POST['appointment_date'] ?? ''); ?>">
           
           

            <button type="submit">Check Available Times</button>
        </form>
    <?php endif; ?>

    <?php
// Define time slots and breaks
$time_slots = ["09:00", "10:00", "10:20", "10:40", "11:00", "11:20", "11:40", "12:00", "12:20", 
               "12:40", "01:20",  "01:40", "03:00", "03:20", "03:40", "04:00", "04:20", "04:40", "05:00"];

// Define break periods
$breaks = [ "01:40"];
$reports= ["09:00", "05:00"];




?>

  

<!-- Available Time Slots -->
<?php if (isset($_POST['appointment_date']) && isset($_POST['doctor_id'])): ?>
    <h3>Available Time Slots</h3>
    <div style="display: flex; flex-wrap: wrap;">
    <form action="" method="post">
        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>"> <!-- Preserve phone number -->
        <input type="hidden" name="appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>">
        <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor_id); ?>">
        <input type="hidden" id="appointment_time" name="appointment_time" required>

        <?php
        // Render both available, booked, and break time slots
        foreach ($time_slots as $slot) {
            // Check if the slot is a break or already booked
            $class = '';
            $label = $slot;  // Default label is the time itself

            if (in_array($slot, $booked_times)) {
                $class = 'booked';  // Already booked
            } elseif (in_array($slot, $breaks)) {
                $class = 'break';  // Break period
                $label = "Break";   // Show 'Break' instead of the time
            }
            elseif (in_array($slot, $reports)) {
                $class = 'reports';  // Break period
                $label = "Review Reports";   // Show 'Break' instead of the time
            }

            echo "<div class='time-slot $class' data-time='$slot' onclick='selectTime(this)'>$label</div>";
        }
        ?>
    </div>
    <br><br>
    <button type="submit">Book Appointment</button>
    </form>
<?php endif; ?>


</div>

</body>
</html>
