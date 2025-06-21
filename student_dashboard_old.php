<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks Page</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('Images/student1.jpeg'); /* Add your background image here */
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px; /* Increased padding for a better layout */
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white for better contrast */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px; /* Increased font size */
            font-weight: bold;
            color: #333; /* Darker color for better readability */
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Increased gap for spacing */
            margin: 20px 0;
        }

        button, a {
            padding: 15px 25px; /* Increased padding for buttons */
            font-size: 18px; /* Increased font size */
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s; /* Added scale effect on hover */
        }

        button:hover, a:hover {
            background-color: #0056b3;
            transform: scale(1.05); /* Slightly enlarge button on hover */
        }

        input[type="text"], input[type="password"], select {
            padding: 12px;
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc; /* Add border for better input visibility */
            border-radius: 5px; /* Rounded corners */
        }

        input[type="submit"] {
            padding: 12px 25px;
            font-size: 18px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s; /* Added scale effect on hover */
        }

        input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05); /* Slightly enlarge submit button on hover */
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .marks-table th, .marks-table td {
            border: 1px solid #ddd;
            padding: 10px; /* Increased padding for better table readability */
            text-align: center;
        }

        .marks-table th {
            background-color: #007BFF;
            color: white;
            font-weight: bold; /* Make header text bold */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Student Marks Page</div>

        <div class="button-container">
            <button onclick="showForm('internal')">View Internal Marks</button>
            <button onclick="showForm('external')">View External Marks</button>
        </div>

        <div id="marksForm" style="display:none;">
            <form method="POST" action="">
                <input type="hidden" name="action" id="action" value="">
                <input type="text" name="rollno" placeholder="Enter Roll Number" required>
                <input type="password" name="password" placeholder="Enter Password" required>
                <select name="year" required>
                    <option value="">Select Academic Year</option>
                    <option value="2021-2022">2021-2022</option>
                    <option value="2022-2023">2022-2023</option>
                    <option value="2023-2024">2023-2024</option>
                </select>
                <select name="semester" id="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
                <select name="dept" id="dept" required>
                    <option value="">Select Department</option>
                    <option value="CSE">CSE</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                    <option value="CIVIL">CIVIL</option>
                    <option value="MECH">MECH</option>
                </select>
                <select name="subject" required id="subject" style="display:none;">
                    <option value="">Select Subject</option>
                </select>
                <input type="submit" value="View Marks">
            </form>
        </div>

        <?php
        // Connect to MySQL database
        $conn = new mysqli('localhost', 'root', '', 'tracking');  // Update with your DB credentials

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rollno = $_POST['rollno'];
            $password = $_POST['password'];
            $year = $_POST['year'];
            $semester = $_POST['semester'];
            $dept = $_POST['dept'];
            $subject = $_POST['subject'] ?? null;

            // Validate credentials from students_pwrd table
            $sql = "SELECT * FROM students_pwrd WHERE rollno = '$rollno' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // If credentials are valid, fetch marks from 'toc' table
                if ($_POST['action'] === 'internal' && $subject) {
                    $marks_sql = "SELECT * FROM toc WHERE rollno = '$rollno' ";
                    $marks_result = $conn->query($marks_sql);

                    if ($marks_result->num_rows > 0) {
                        $marks = $marks_result->fetch_assoc();
                        echo '<table class="marks-table">';
                        echo '<tr><th>Internal Assessment 1</th><th>Internal Assessment 2</th><th>Internal Assessment 3</th><th>Assignment 1</th><th>Assignment 2</th><th>Attendance %</th></tr>';
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($marks['internal1']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks['internal2']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks['internal3']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks['assignment1']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks['assignment2']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks['attendance_percentage']) . '%</td>';
                        echo '</tr>';
                        echo '</table>';
                    } else {
                        echo '<p>No marks found for the selected subject.</p>';
                    }
                } elseif ($_POST['action'] === 'external') {
                    // For external marks, we are just simulating the display here
                    echo '<p>External marks for ' . htmlspecialchars($dept) . ' in ' . htmlspecialchars($year) . ', Semester ' . htmlspecialchars($semester) . ' retrieved successfully.</p>';
                }
            } else {
                echo '<p>Invalid Roll Number or Password.</p>';
            }
        }

        $conn->close();
        ?>
    </div>

    <script>
        function showForm(type) {
            document.getElementById('marksForm').style.display = 'block';
            document.getElementById('action').value = type; // store action type
            const subjectSelect = document.getElementById('subject');
            if (type === 'external') {
                subjectSelect.style.display = 'none'; // hide subject for external
                subjectSelect.required = false; // make subject non-required
            } else {
                subjectSelect.style.display = 'block'; // show subject for internal
                subjectSelect.required = true; // make subject required
                // You can populate the subjects dynamically based on the selected department
                populateSubjects(document.getElementById('dept').value);
            }
        }


        const subjects = {
            'CSE': {
                '1': ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming'],
                '2': ['HS3252 Professional English - II', 'BE3251 Basic Electrical and Electronics Engineering', 'MA3251 Statistics and Numerical Methods', 'PH3202 Physics for Information Science', 'CS3251 Programming in C'],
                '3': ['MA3354 Discrete Mathematics', 'CS3351 Digital Principles and Computer Organization', 'CS3352 Foundations of Data Science', 'CS3301 Data Structures', 'CS3391 Object Oriented Programming'],
                '4': ['CS3452 Theory of Computation', 'CS3491 Artificial Intelligence and Machine Learning', 'CS3401 Algorithms', 'CS3451 Introduction to Operating Systems'],
                '5': ['CS3591 Computer Networks', 'CS3501 Compiler Design', 'CB3491 Cryptography and Cyber Security'],
                '6': ['CCS356 Object Oriented Software Engineering', 'CS3691 Embedded Systems and IoT'],
                '7': ['GE3791 Human Values and Ethics'],
                '8': ['CS3811 Project Work/Internship'],
            },
            'ECE': {
                '1': ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming'],
                '2': ['HS3252 Professional English - II', 'MA3251 Statistics and Numerical Methods', 'PH3202 Physics for Electrical Engineering', 'BE3254 Electrical and Instrumentation Engineering', 'GE3251 Engineering Graphics'],
                '3': ['MA3355 Random Processes and Linear Algebra', 'CS3353 C Programming and Data Structures', 'EC3354 Signals and Systems', 'EC3353 Electronic Devices and Circuits', 'EC3351 Control Systems'],
                '4': ['EC3452 Electromagnetic Fields', 'EC3401 Networks and Security', 'EC3451 Linear Integrated Circuits', 'Digital Signal Processing'],
                '5': ['EC3501 Wireless Communication', 'EC3552 VLSI and Chip Design'],
                '6': ['ET3491 Embedded Systems and IoT Design', 'CS3491 Artificial Intelligence and Machine Learning'],
                '7': ['GE3791 Human Values and Ethics'],
                '8': ['EC3811 Project Work/Internship'],
            },
            'EEE': {
                '1': ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming'],
                '2': ['HS3252 Professional English - II', 'MA3251 Statistics and Numerical Methods', 'PH3202 Physics for Electrical Engineering', 'BE3255 Basic Civil and Mechanical Engineering', 'GE3251 Engineering Graphics'],
                '3': ['MA3355 Random Processes', 'EE3351 Circuit Theory', 'EE3352 Electrical Machines - II', 'EE3353 Control Systems', 'EE3354 Electrical Measurements'],
                '4': ['EE3451 Power Systems', 'EE3452 Power Electronics', 'EE3401 Digital Signal Processing', 'EE3402 Analog and Digital Communication'],
                '5': ['EE3501 High Voltage Engineering', 'EE3502 Renewable Energy'],
                '6': ['EE3601 Industrial Drives', 'EE3602 Electrical Safety Engineering'],
                '7': ['GE3791 Human Values and Ethics'],
                '8': ['EE3811 Project Work/Internship'],
            },
            'CIVIL': {
                '1': ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming'],
                '2': ['HS3252 Professional English - II', 'MA3251 Statistics and Numerical Methods', 'CE3251 Mechanics of Materials', 'CE3252 Fluid Mechanics'],
                '3': ['CE3351 Structural Analysis', 'CE3352 Concrete Technology', 'CE3353 Soil Mechanics'],
                '4': ['CE3451 Design of Concrete Structures', 'CE3452 Design of Steel Structures'],
                '5': ['CE3501 Estimation and Costing'],
                '6': ['CE3601 Advanced Structural Analysis'],
                '7': ['GE3791 Human Values and Ethics'],
                '8': ['CE3811 Project Work/Internship'],
            },
            'MECH': {
                '1': ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming'],
                '2': ['HS3252 Professional English - II', 'MA3251 Statistics and Numerical Methods', 'ME3251 Engineering Mechanics', 'ME3252 Thermodynamics'],
                '3': ['MA3355 Fluid Mechanics', 'ME3351 Strength of Materials', 'ME3352 Machine Design'],
                '4': ['ME3451 Thermal Engineering', 'ME3452 Dynamics of Machinery'],
                '5': ['ME3501 Operations Research'],
                '6': ['ME3601 Advanced Manufacturing Processes'],
                '7': ['GE3791 Human Values and Ethics'],
                '8': ['ME3811 Project Work/Internship'],
            },
        };

        document.getElementById('dept').addEventListener('change', function() {
            const dept = this.value;
            const semester = document.getElementById('semester').value;
            const subjectSelect = document.getElementById('subject');

            // Clear previous subjects
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

            if (dept && semester) {
                subjects[dept][semester].forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject;
                    option.textContent = subject;
                    subjectSelect.appendChild(option);
                });
            }
        });

        document.getElementById('semester').addEventListener('change', function() {
            const dept = document.getElementById('dept').value;
            const semester = this.value;
            const subjectSelect = document.getElementById('subject');

            // Clear previous subjects
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

            if (dept && semester) {
                subjects[dept][semester].forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject;
                    option.textContent = subject;
                    subjectSelect.appendChild(option);
                });
            }
        });
    </script>
</body>

</html>
