<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        
    font-family: Arial, sans-serif;
    background-image: url('Images/fac.jpeg'); /* Change this to your image path */
    background-size: cover; /* Cover the entire screen */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Don't repeat the image */
    padding: 20px;
}
html, body {
    height: 100%; /* Ensure the body takes full height */
}


        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .button-container, .link-container, .subject-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        button, a {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        button:hover, a:hover {
            background-color: #0056b3;
        }

        .subject-container {
            flex-direction: column;
            align-items: center;
        }

        .subject-item {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            margin: 5px;
            width: 80%;
            text-align: center;
            border-radius: 5px;
        }

        .marks-entry {
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Check which step of navigation we are on
        if (!isset($_GET['page'])) {
            // Default to faculty login
            $_GET['page'] = 'login';
        }
        $page = $_GET['page'];

        switch ($page) {
            case 'login': ?>
                <div class="title">Faculty Login</div>
                <form method="GET" action="">
                    <input type="hidden" name="page" value="selectYear">
                    <input type="submit" value="Login as Faculty">
                </form>
                <?php break;

            case 'selectYear': ?>
                <div class="title">Select Academic Year</div>
                <div class="button-container">
                    <a href="?page=selectDept&year=2021">2021-2022</a>
                    <a href="?page=selectDept&year=2022">2022-2023</a>
                    <a href="?page=selectDept&year=2023">2023-2024</a>
                </div>
                <?php break;

            case 'selectDept': ?>
                <div class="title">Select Department</div>
                <div class="link-container">
                    <a href="?page=selectSemester&dept=CSE">CSE</a>
                    <a href="?page=selectSemester&dept=ECE">ECE</a>
                    <a href="?page=selectSemester&dept=EEE">EEE</a>
                    <a href="?page=selectSemester&dept=CIVIL">CIVIL</a>
                    <a href="?page=selectSemester&dept=MECH">MECH</a>
                </div>
                <?php break;

            case 'selectSemester': ?>
                <div class="title">Select Semester</div>
                <div class="link-container">
                    <a href="?page=selectSubject&sem=1">Semester 1</a>
                    <a href="?page=selectSubject&sem=2">Semester 2</a>
                    <a href="?page=selectSubject&sem=3">Semester 3</a>
                    <a href="?page=selectSubject&sem=4">Semester 4</a>
                    <a href="?page=selectSubject&sem=5">Semester 5</a>
                    <a href="?page=selectSubject&sem=6">Semester 6</a>
                    <a href="?page=selectSubject&sem=7">Semester 7</a>
                    <a href="?page=selectSubject&sem=8">Semester 8</a>
                </div>
                <?php break;

            case 'selectSubject': ?>
                <div class="title">Select Subject</div>
                <div class="subject-container">
                    <!-- Link to faculty_marksheet.php page with subject information -->
                    <div class="subject-item"><a href="faculty_marksheet.php?page=markEntry&subject=MAT101">Mathematics - MAT101</a></div>
                    <div class="subject-item"><a href="faculty_marksheet.php?page=markEntry&subject=PHY102">Physics - PHY102</a></div>
                    <div class="subject-item"><a href="faculty_marksheet.php?page=markEntry&subject=CHE103">Chemistry - CHE103</a></div>
                    <div class="subject-item"><a href="faculty_marksheet.php?page=markEntry&subject=CSE104">Programming - CSE104</a></div>
                    <div class="subject-item"><a href="faculty_marksheet.php?page=markEntry&subject=EEE105">Electronics - EEE105</a></div>
                </div>
                <?php break;

            case 'markEntry': ?>
                <div class="title">Enter Marks for <?php echo htmlspecialchars($_GET['subject']); ?></div>
                <div class="marks-entry">
                    <form method="post" action="">
                        <input type="text" name="marks" placeholder="Enter Marks">
                        <input type="submit" value="Submit Marks">
                    </form>
                </div>
                
                <?php break;

            default:
                echo "<div class='title'>Invalid Page</div>";
                break;
        }
        ?>
    </div>
</body>
</html>
