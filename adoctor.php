<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'doc');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Doctor Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $exp = $_POST['experience'];
    $edu = $_POST['education'];
    $bio = $_POST['bio'];

    // Insert doctor data into the database
    $query = "INSERT INTO doctors (name, specialization, phone, email, password, experience, education, biography) 
              VALUES ('$name', '$specialty', '$phone', '$email', '$password', '$exp', '$edu', '$bio')";
    if ($conn->query($query)) {
        echo "<script>alert('Doctor added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding doctor: " . $conn->error . "');</script>";
    }
}

// Handle Delete Doctor Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_doctor'])) {
    $doctor_id = $_POST['doctor_id'];

    $query = "DELETE FROM doctors WHERE id='$doctor_id'";
    if ($conn->query($query)) {
        echo "<script>alert('Doctor deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting doctor: " . $conn->error . "');</script>";
    }
}

// Handle Mark as On Leave Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_on_leave'])) {
    $doctor_id = $_POST['doctor_id'];

    // Update doctor's leave status in doctors table
    $query = "UPDATE doctors SET on_leave = 1 WHERE id='$doctor_id'";
    if ($conn->query($query)) {
        // Update appointments table to reflect doctor's leave
        $update_appointments = "UPDATE appointments SET status='Doctor on Leave' WHERE doctor_id='$doctor_id' AND status='Confirmed'";
        $conn->query($update_appointments);
        echo "<script>alert('Doctor marked as on leave successfully!');</script>";
    } else {
        echo "<script>alert('Error updating leave status: " . $conn->error . "');</script>";
    }
}

// Handle Mark as Available Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_available'])) {
    $doctor_id = $_POST['doctor_id'];

    // Update doctor's availability in doctors table
    $query = "UPDATE doctors SET on_leave = 0 WHERE id='$doctor_id'";
    if ($conn->query($query)) {
        // Optionally update appointments to reflect availability
        $update_appointments = "UPDATE appointments SET status='Confirmed' WHERE doctor_id='$doctor_id' AND status='Doctor on Leave'";
        $conn->query($update_appointments);

        echo "<script>alert('Doctor marked as available successfully!');</script>";
    } else {
        echo "<script>alert('Error updating availability: " . $conn->error . "');</script>";
    }
}


// Fetch All Doctors
$doctors = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            width: 75%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        
        }
        .sidebar a.active {
            background-color: #0056b3;
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
            background-color: black;
            color: #fff;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-leave {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-add {
            background-color: #28a745;
            color: #fff;
        }

        .collapsible {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: left;
            cursor: pointer;
            width: 100%;
            border: none;
            outline: none;
            font-size: 18px;
        }

        .collapsible:hover {
            background-color: #0056b3;
        }

        .content {
            padding: 10px 20px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }
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
        
    .content form input[type="text"],
    .content form input[type="email"],
    .content form textarea {
        width: 100%; /* Adjust the width to take up full container space */
        max-width: 500px; /* Set a maximum width for larger screens */
        height: 40px; /* Increase the height of the input boxes */
        padding: 10px; /* Add padding for better spacing inside the box */
        font-size: 16px; /* Increase font size for readability */
        border: 1px solid #ccc; /* Add a light border */
        border-radius: 5px; /* Rounded corners */
        box-sizing: border-box; /* Ensure padding doesn't affect width */
        margin-bottom: 20px; /* Add space between fields */
    }

    .content form textarea {
        height: 100px; /* Set a larger height for the textarea */
        resize: vertical; /* Allow resizing vertically only */
    }

    .content form button {
       /* Button background color */
        color: white; /* Text color */
        font-size: 18px; /* Font size for the button */
        padding: 10px 20px; /* Padding for the button */
        border: none; /* Remove border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
    }

    .content form button:hover {
        background-color: #7070db; /* Change color on hover */
    }




     

    </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
        <div>
            <h2>Admin Dashboard</h2>
            <ul>
            <li><a href="adashbrd.php">Home</a></li>
                <li><a href="adashbrd.php">Manage Appointments</a></li>
                <li><a href="adoctor.php" class="active">Manage Doctors</a></li>
                <li><a href="areport.php">View Patients Reports</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
       
    </div>

    <div class="container">
        <h1>Manage Doctors</h1>

        <!-- Add New Doctor Section -->
        <button class="collapsible">Add New Doctor</button>
        <div class="content">
            <form method="POST">
                <input type="text" name="name" placeholder="Doctor's Name" required><br><br>
                <input type="text" name="specialty" placeholder="Specialty" required><br><br>
                <input type="text" name="phone" placeholder="Phone" required><br><br>
                <input type="email" name="email" placeholder="Email" required><br><br>
                <input type="text" name="password" placeholder="Password" required><br><br>
                <input type="text" name="experience" placeholder="Experience" required><br><br>
                <input type="text" name="education" placeholder="Education" required><br><br>
                <textarea name="bio" placeholder="Biography" required></textarea><br><br>
                <button type="submit" name="add_doctor" class="btn btn-add">Add Doctor</button>
            </form>
        </div>

        <!-- Doctor List Section -->
        <button class="collapsible">Doctor List</button>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialty</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($doctor = $doctors->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $doctor['id']; ?></td>
                            <td><?php echo $doctor['name']; ?></td>
                            <td><?php echo $doctor['email']; ?></td>
                            <td><?php echo $doctor['specialization']; ?></td>
                            <td><?php echo $doctor['phone']; ?></td>
                            
                            <td>
    <!-- Delete Doctor -->
    <form method="POST" style="display:inline;">
        <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
        <button type="submit" name="delete_doctor" class="btn btn-delete">Delete</button>
    </form>

    
</td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Add event listeners to collapsible buttons
        var coll = document.getElementsByClassName("collapsible");
        for (var i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
