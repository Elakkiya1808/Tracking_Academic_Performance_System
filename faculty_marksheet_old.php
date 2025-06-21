<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Entry - <?php echo htmlspecialchars($_GET['subject']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
            background-image: url('Images/dash1.png'); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            height: 100vh;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background-image: url('Images/dash.jpg'); /* Replace with your container image URL */
            background-size: cover;
            background-position: center;
            border: 2px solid #fff; /* Adding border to the container */
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #007BFF;
            text-transform: uppercase;
        }
        .details {
            font-size: 18px;
            font-weight: normal;
            color: #555;
            margin-bottom: 20px;
        }
        .details p {
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .details span {
            font-weight: bold;
            color: #007BFF;
        }
        .details .label {
            color: white; /* White for labels */
            font-weight: bold;
        }
        button {
            padding: 12px 24px;
            font-size: 18px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-right: 15px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Slight lift effect */
        }
        button:focus {
            outline: none;
        }
        .buttons {
            text-align: center;
            margin-top: 30px;
        }
        .container .buttons button {
            width: 200px;
        }
        /* Extra responsive styling */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .buttons button {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Get parameters from the URL
        $subject = $_GET['subject'] ?? '';
        $year = $_GET['year'] ?? '';
        $dept = $_GET['dept'] ?? '';
        $sem = $_GET['sem'] ?? '';
        ?>

        <div class="title">Marks Entry for <?php echo htmlspecialchars($subject); ?></div>

        <!-- Direct details without container -->
        <div class="details">
            <p><span class="label">Academic Year:</span> <span><?php echo htmlspecialchars($year); ?></span></p>
            <p><span class="label">Department:</span> <span><?php echo htmlspecialchars($dept); ?></span></p>
            <p><span class="label">Semester:</span> <span><?php echo htmlspecialchars($sem); ?></span></p>
            <p><span class="label">Subject:</span> <span><?php echo htmlspecialchars($subject); ?></span></p>
        </div>

        <!-- Buttons to choose the action -->
        <div class="buttons">
            <button onclick="window.location.href='marks_management1.php?subject=<?php echo urlencode($subject); ?>&year=<?php echo urlencode($year); ?>&dept=<?php echo urlencode($dept); ?>&sem=<?php echo urlencode($sem); ?>'">Add New Data</button>
            <button onclick="window.location.href='marks_management_edit1_old.php?subject=<?php echo urlencode($subject); ?>&year=<?php echo urlencode($year); ?>&dept=<?php echo urlencode($dept); ?>&sem=<?php echo urlencode($sem); ?>'">Edit Marks</button>
            <button onclick="window.location.href='marks_management_view_old.php?subject=<?php echo urlencode($subject); ?>&year=<?php echo urlencode($year); ?>&dept=<?php echo urlencode($dept); ?>&sem=<?php echo urlencode($sem); ?>'">View Marks</button>
        </div>
    </div>
</body>
</html>
