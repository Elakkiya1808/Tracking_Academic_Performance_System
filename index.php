<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker</title>
    <style>
        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
       
            background-image: url('Images/fac.jpeg'); 
            background-size: cover;
            background-position: center;
            color: black;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 100px; /* Adjust size as needed */
            height: auto;
            margin-right: 10px;
        }

        .project-title {
            font-size: 24px;
            font-weight: bold;
        }

        .nav {
            display: flex;
            gap: 20px;
        }

        .nav a {
            color: black;
            text-decoration: none;
            font-size: 18px;
        }

        .welcome-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        .welcome-box h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .welcome-box p {
            font-size: 16px;
        }
        body {
    background-image: url('Images/home1.png'); /* Replace with the path to your image */
    background-size: cover; /* Cover the entire element */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    height: 100vh; /* Full height of the viewport */
    display: flex; /* Flexbox for centering content */
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white; /* Text color */
    text-align: center;
}
    </style>
</head>
<body>
<!-- <div class="background-image">
        <h1>Welcome to My Website</h1>
        <p>This is an example of a background image using CSS.</p>
    </div> -->

    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <img src="Images/collegelogo.png" alt="College Logo"> <!-- Replace with your logo path -->
                <div class="project-title">Academic Performance Tracker</div>
            </div>
            <div class="nav">
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
            </div>
        </div>

        <!-- Welcome Box -->
        <div class="welcome-box">
            <h1>Welcome</h1>
            <p>Track your academic performance with ease.</p>
        </div>
    </div>
</body>
</html>
