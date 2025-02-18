<?php
session_start(); 
// Initialize $error as an empty string to avoid undefined variable warning
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f7f9;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 90vh;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Left Section with Image */
        .left-section {
            flex: 1;
            background: url('img/plogin.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3); /* Dark overlay for better text visibility */
        }

        .left-section-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            z-index: 1;
        }

        .left-section-text h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .left-section-text p {
            font-size: 18px;
            line-height: 1.6;
        }

        /* Right Section with Form */
        .right-section {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            text-align: center;
        }

        /* Adjust Language Container Placement */
        .language-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px; /* Adds space below the language selector */
        }

        .language-container select {
            padding: 5px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
        }

        .login-container h2 {
            margin-bottom: 15px;
            color: #333;
            font-weight: 700;
        }

        .login-container h4 {
            color: #666;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .login-container input[type="submit"] {
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: #004d99;
        }

        .login-container h3 {
            margin-top: 15px;
            font-size: 14px;
        }

        .login-container h3 a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }

        .login-container h3 a:hover {
            text-decoration: underline;
        }

        .login-container h5 {
            margin-top: 20px;
            font-size: 14px;
        }

        .login-container h5 a {
            color: #0066cc;
            text-decoration: none;
        }

        .login-container h5 a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .left-section {
                height: 200px;
            }

            .right-section {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Left Section -->
        <div class="left-section">
            <div class="left-section-text">
                <h1>Welcome Back!</h1>
                <p>Login to access your account and manage your appointments easily.</p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-container">
                <!-- Language Selection Container -->
                <div class="language-container">
                    <select id="language" onchange="changeLanguage()">
                        <option value="en">English</option>
                        <option value="kn">Kannada</option>
                    </select>
                </div>

                <h2 id="login-title">Patient Login</h2>
                <h4 id="caption">Login with your details to continue...</h4>
                <form action="login.php" method="POST">

                 <!-- Error message -->
                 <div class="error-message" id="error-message">
                        <?php
                        // Check if there is an error and show it in an alert
                        if (!empty($error)) {
                            echo "<script>alert('$error');</script>";
                            unset($_SESSION['error']); // Clear the error after displaying the alert
                        }
                        ?>
                    </div>

                   

                    <!-- Username Field -->
                    <input type="text" name="username" id="username" placeholder="Username" required>

                    <!-- Password Field -->
                    <input type="password" name="password" id="password" placeholder="Password" required>

                    <!-- Submit Button -->
                    <input type="submit" id="login-b" value="Login">
                    </form>

                 

                    <!-- Sign Up Link -->
                    <h3 id="signup">Don't have an account? <a href="psignup.php">Sign Up</a></h3>

                    <!-- Home Link -->
                    <h5 id="back"><a href="index.php">Back to Home Page</a></h5>
               
            </div>

            <script>
                function changeLanguage() {
                    const language = document.getElementById('language').value;

                    if (language === 'kn') {
                        document.getElementById('login-title').textContent = 'ಬಳಕೆದಾರ ಲಾಗಿನ್';
                        document.getElementById('caption').textContent = 'ಮುಂದುವರಿಸಲು ನಿಮ್ಮ ವಿವರಗಳೊಂದಿಗೆ ಲಾಗಿನ್ ಮಾಡಿ...';
                        document.getElementById('username').placeholder = 'ಹೆಸರು';
                        document.getElementById('password').placeholder = 'ಗುಪ್ತಪದ';
                        document.getElementById('login-b').value = 'ಸಲ್ಲಿಸು';
                        document.getElementById('signup').innerHTML = 'ಖಾತೆ ಇಲ್ಲವೇ? <a href="psignup.php"><span id="sid">ಸೈನ್ ಅಪ್</span></a>';
                        document.getElementById('back').innerHTML = '<a href="index.php">ಹೋಮ್ ಪುಟಕ್ಕೆ ಹಿಂದಿರುಗಿ</a>';
                    } else {
                        document.getElementById('login-title').textContent = 'Patient Login';
                        document.getElementById('caption').textContent = 'Login with your details to continue...';
                        document.getElementById('username').placeholder = 'Username';
                        document.getElementById('password').placeholder = 'Password';
                        document.getElementById('login-b').value = 'Login';
                        document.getElementById('signup').innerHTML = 'Don\'t have an account? <a href="psignup.php"><span id="sid">Sign Up</span></a>';
                        document.getElementById('back').innerHTML = '<a href="index.php">Back to Home Page</a>';
                    }
                }
            </script>
        </div>
    </div>

   
</body>
</html>
