<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('pb1.jpg'); /* Add background image URL */
            background-size: cover;
            background-position: center;
        }
        .signup-container {
            background: rgba(255, 255, 255, 0.6);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .signup-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .signup-container input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .signup-container input[type="submit"] {
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .signup-container input[type="submit"]:hover {
            background-color: #004d99;
        }
        .signup-container input[type="submit"]:active {
            background-color: #003366;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Language Dropdown Styling */
        .language-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .language-container select {
            padding: 5px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Language Selection Dropdown -->
    <div class="language-container">
        <select id="language" onchange="changeLanguage()">
            <option value="en">English</option>
            <option value="kn">Kannada</option>
        </select>
    </div>

    <div class="signup-container">
        <h2 id="signup-heading">Sign Up</h2>
        <form action="signup.php" method="POST">
            <!-- Error message will be displayed here -->
            <div class="error-message" id="error-message"></div>

            <input type="text" name="name" id="name" placeholder="Username" required>
            <input type="email" name="email" id="email" placeholder="Email" >
            <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
            <input type="text" name="gender" id="gender" placeholder="Gender" >
            <input type="text" name="age" id="age" placeholder="Age" >
            <input type="address" name="address" id="address" placeholder="Address" required>
            <input type="password" name="password" id="password" placeholder="Password" required>

            <input type="submit" value="Sign Up">
        </form>
    </div>

    <script>
        function changeLanguage() {
            const language = document.getElementById('language').value;

            if (language === 'kn') {
                document.getElementById('signup-heading').textContent = 'ಸೈನ್ ಅಪ್';
                document.getElementById('name').placeholder = 'ಹೆಸರು';
                document.getElementById('email').placeholder = 'ಇಮೇಲ್';
                document.getElementById('phone').placeholder = 'ದೂರವಾಣಿ ಸಂಖ್ಯೆ';
                document.getElementById('gender').placeholder = 'ಲಿಂಗ';
                document.getElementById('age').placeholder = 'ವಯಸ್ಸು';
                document.getElementById('address').placeholder = 'ವಿಳಾಸ';
                document.getElementById('password').placeholder = 'ಗುಪ್ತಪದ';
                document.querySelector("input[type='submit']").value = 'ಸೈನ್ ಅಪ್';
            } else {
                document.getElementById('signup-heading').textContent = 'Sign Up';
                document.getElementById('name').placeholder = 'Username';
                document.getElementById('email').placeholder = 'Email';
                document.getElementById('phone').placeholder = 'Phone Number';
                document.getElementById('gender').placeholder = 'Gender';
                document.getElementById('age').placeholder = 'Age';
                document.getElementById('address').placeholder = 'Address';
                document.getElementById('password').placeholder = 'Password';
                document.querySelector("input[type='submit']").value = 'Sign Up';
            }
        }
    </script>

</body>
</html>
