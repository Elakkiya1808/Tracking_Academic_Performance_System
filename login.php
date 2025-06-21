<?php
// Start a session to manage login state
session_start();

// Initialize variables for errors
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['user_type'];
    $id = trim($_POST['id']);
    $password = trim($_POST['password']);

    if (empty($id) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        $conn = new mysqli('127.0.0.1', 'root', '', 'tracking', 3306);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($userType === 'admin') {
            $sql = "SELECT * FROM admins WHERE admin_id = ?";
        } elseif ($userType === 'student') {
            $sql = "SELECT * FROM studentlogin WHERE student_id = ?";
        } elseif ($userType === 'faculty') {
            $sql = "SELECT * FROM faculty WHERE faculty_id = ?";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "ID: $id<br>";
        echo "User Type: $userType<br>";
        echo "SQL: $sql<br>";
        echo "Result Count: " . $result->num_rows . "<br>";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                echo "Password match success!<br>";
                $_SESSION['user_type'] = $userType;
                $_SESSION['user_id'] = $id;
        
                // Redirect based on user type
                if ($userType === 'admin') {
                    header("Location: Semester_demo.php"); // Change to your admin page
                } elseif ($userType === 'student') {
                    header("Location: student_dashboard.php"); // Change to your student page
                } elseif ($userType === 'faculty') {
                    header("Location: Semester_demo_old.php"); // Already your faculty page
                }
                exit();
            } else {
                $error_message = "Invalid credentials. Please try again.";
            }
        } else {
            $error_message = "Invalid credentials. Please try again.";
        }
        

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics Performance Tracking - Login</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="Images\collegelogo.png" alt="College Logo"> <!-- Replace with your logo path -->
            <div class="project-title">Academic Performance Tracker</div>
        </div>
        <div class="nav">
            <a href="index1.php">Home</a>
            <a href="login.php">Login</a>
        </div>
    </div>

    <div class="container">
        <h1>Academics Performance Tracking</h1>

        <div class="login-section">
            <!-- PHP code to display error messages -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Buttons to show different login forms -->
            <button onclick="showLogin('admin')">Admin Login</button>
            <button onclick="showLogin('student')">Student Login</button>
            <button onclick="showLogin('faculty')">Faculty Login</button>
        </div>

        <!-- Admin Login Form -->
        <form id="admin-login" class="login-form" style="display: none;" method="post" action="">
            <h2>Admin Login</h2>
            <input type="hidden" name="user_type" value="admin">
            <input type="text" name="id" placeholder="Admin ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Student Login Form -->
        <form id="student-login" class="login-form" style="display: none;" method="post" action="">
            <h2>Student Login</h2>
            <input type="hidden" name="user_type" value="student">
            <input type="text" name="id" placeholder="Student ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Faculty Login Form -->
        <form id="faculty-login" class="login-form" style="display: none;" method="post" action="">
            <h2>Faculty Login</h2>
            <input type="hidden" name="user_type" value="faculty">
            <input type="text" name="id" placeholder="Faculty ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
   
    <style>
        /* Apply a background image to the entire page */
        body {
            background-image: url('Images/loginnew.jpeg'); /* Update this path to your image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating the image */
            margin: 0; /* Remove default margin */
            height: 100vh; /* Full viewport height */
            font-family: Arial, sans-serif; /* Set a default font */
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            height: 80px;
            padding: 0 20px; /* Add padding on the sides */
            position: fixed; /* Fix the header at the top */
            top: 0; /* No gap from the top of the page */
            width: 100%;
            z-index: 1000; /* Ensure header stays above other content */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .logo {
            display: flex;
            align-items: center;
            flex-shrink: 0; /* Prevent logo from shrinking */
        }

        .logo img {
            width: 100px; /* Adjust size as needed */
            height: auto;
            margin-right: 10px;
        }

        .nav {
            display: flex;
            gap: 20px;
            flex-shrink: 0; /* Prevent navigation from shrinking */
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        /* Container for centering content */
        .container {
            padding: 100px 20px; /* Adjust padding to account for fixed header */
            text-align: center;
        }

        /* Styling for the heading */
        h1 {
            color: white; /* White color for the main heading */
            margin-bottom: 20px;
        }

        /* Styling for the login section with buttons */
        .login-section {
            margin-bottom: 30px;
        }

        .login-section button {
            background-color: black; /* Button color */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding */
            margin: 10px; /* Space between buttons */
            cursor: pointer; /* Pointer cursor on hover */
            border-radius: 5px; /* Rounded corners */
            font-size: 16px; /* Font size */
        }

        .login-section button:hover {
            background-color: #333; /* Darker color on hover */
        }

        /* Common styling for all login forms */
        .login-form {
            display: inline-block; /* Center form horizontally */
            background-color: black;
            opacity: .7;
            border-radius: 10px; /* Rounded corners */
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
            width: 300px; /* Form width */
            margin: 20px auto; /* Center form horizontally with some margin at the top */
            text-align: center;
        }

        /* Styling for input fields */
        .login-form input {
            display: block;
            width: calc(100% - 20px); /* Full width minus padding */
            padding: 10px;
            margin: 10px 0; /* Space between inputs */
            border: 1px solid #ccc; /* Border color */
            border-radius: 5px; /* Rounded corners */
        }

        /* Styling for the login button in forms */
        .login-form button {
            background-color: #007bff; /* Button color */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding */
            cursor: pointer; /* Pointer cursor on hover */
            border-radius: 5px; /* Rounded corners */
            font-size: 16px; /* Font size */
        }

        .login-form button:hover {
            background-color: #0056b3; /* Darker color on hover */
        }

        /* Styling for error messages */
        .error-message {
            color: red; /* Red color for error messages */
            display: block;
            margin-top: 10px; /* Space above error message */
        }
    </style>

    <script>
        function showLogin(type) {
            document.getElementById('admin-login').style.display = 'none';
            document.getElementById('student-login').style.display = 'none';
            document.getElementById('faculty-login').style.display = 'none';

            document.getElementById(type + '-login').style.display = 'block';
        }
    </script>
</body>
</html>
