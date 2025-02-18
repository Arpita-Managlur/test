
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection settings
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "doc";

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the appointment ID from the form
        $appointment_id = intval($_POST['appointment_id']);

        // Prepare the SQL query to delete the appointment
        $sql = "DELETE FROM appointments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $appointment_id);

        // Execute the query
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<p>Appointment ID $appointment_id has been deleted successfully.</p>";
            } else {
                echo "<p>No appointment found with ID $appointment_id.</p>";
            }
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Appointment</title>
</head>
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
            padding: 20px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
</style>
<body>
      <!-- Sidebar -->
      <div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="pdashbrd.php" >Home</a>
        <a href="pprofile.php" >Profile</a>
        <a href="viewdoctor.php">Doctors</a>
        <a href="pbook.php">Book Appointment</a>
        <a href="phistory.php">Appointment History</a>
        <a href="pdelete.php" class="active">Delete Appointment</a>
        <a href="index.php">Logout</a>
    </div>
    <div class="content">
        <!-- Header -->
        <div class="header">
            <h2>Delete Appointment</h2>
            
        </div>
        <br><br>

        <label for="appointment_id">Appointment ID:</label>
        <input type="number" id="appointment_id" name="appointment_id" required><br><br>
        <button type="submit">Delete Appointment</button>
   
    </div>

</body>
</html>
