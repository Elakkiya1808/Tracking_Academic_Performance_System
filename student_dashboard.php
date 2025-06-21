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
            background-image: url('Images/student1.jpeg');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffb6c1;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        button, a {
            padding: 15px 25px;
            font-size: 18px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover, a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        input[type="text"], input[type="password"], select {
            padding: 12px;
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 12px 25px;
            font-size: 18px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .table-wrapper {
    max-width: 100%;
    overflow-x: auto;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.marks-table {
    width: 100%;
    border-collapse: collapse;
}

.marks-table th, .marks-table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 16px;
}

.marks-table th {
    background-color: #c71585;
    color: white;
    font-weight: bold;
}

.marks-table tr:nth-child(even) {
    background-color: #f2f2f2;
}
tr:nth-child(even) {
        background-color: #d3d3d3;
    }

    tr:nth-child(odd) {
        background-color: #ffb6c1;
    }
 

        .hidden {
            display: none;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Student Marks Page</div>

        <?php
           
        $conn = new mysqli('localhost', 'root', '', 'tracking');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $departmentSubjectMap = [
            'CSE' => [
                '1' => [
                    'HS3152 Professional English - I' => 'Cpe1',
                    'MA3151 Matrices and Calculus' => 'Cmac',
                    'PH3151 Engineering Physics' => 'Cep',
                    'CY3151 Engineering Chemistry' => 'Cec',
                    'CS3151 Introduction to Computing' => 'Citc',
                ],
                '2' => [
                    'HS3252 Professional English - II' => 'Cpe2',
                    'BE3251 Basic Electrical and Electronics Engineering' => 'Cbeaee',
                    'MA3251 Advanced Calculus' => 'Cac',
                    'CS3251 Data Structures' => 'Cds',
                ],
            ],
        ];
        $formSubmitted = false;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formSubmitted = true;
            $rollno = trim($_POST['rollno']);
            $password = trim($_POST['password']);
            $year = trim($_POST['year']);
            $semester = trim($_POST['semester']);
            $dept = trim($_POST['dept']);
            $action = trim($_POST['action']);

            $sql = "SELECT * FROM students_pwrd WHERE rollno = '$rollno' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $subjects = $departmentSubjectMap[$dept][$semester];
                if ($action === 'internal') {
                    echo '<div class="table-wrapper">';
                    echo '<table class="marks-table">';
                    echo '<tr><th>Subject</th><th>Internal 1</th><th>Internal 2</th><th>Internal 3</th><th>Assignment 1</th><th>Assignment 2</th><th>Assignment 3</th><th>Attendance %</th></tr>';
                    foreach ($subjects as $subName => $subCode) {
                        $marks_sql = "SELECT * FROM `$subCode` WHERE rollno = '$rollno'";
                        $marks_result = $conn->query($marks_sql);
                        if ($marks_result->num_rows > 0) {
                            $marks = $marks_result->fetch_assoc();
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($subName) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['internal1']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['internal2']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['internal3']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['assignment1']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['assignment2']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['assignment3']) . '</td>';
                            echo '<td>' . htmlspecialchars($marks['attendance_percentage']) . '%</td>';
                            echo '</tr>';
                        } else {
                            echo '<tr><td colspan="7">No marks found for ' . htmlspecialchars($subName) . '</td></tr>';
                        }
                    }
                    echo '</table>';
                } elseif ($action === 'external') {
                    echo '<div class="table-wrapper">';
                    $calculateTable = "{$dept}sem{$semester}_calculate_grade";
                    $columns = [];
                    foreach ($subjects as $subCode) {
                        $columns[] = "{$subCode}_total_marks";
                        $columns[] = "{$subCode}_grade";
                    }
                    $marks_sql = "SELECT rollno, " . implode(', ', $columns) . " FROM `$calculateTable` WHERE rollno = '$rollno'";
                    $marks_result = $conn->query($marks_sql);

                    if ($marks_result->num_rows > 0) {
                        $marks = $marks_result->fetch_assoc();
                        echo '<table class="marks-table">';
                        echo '<tr><th>Subject</th><th>Total Marks</th><th>Grade</th></tr>';
                        foreach ($subjects as $subName => $subCode) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($subName) . '</td>';
                            echo '<td>' . htmlspecialchars($marks["{$subCode}_total_marks"]) . '</td>';
                            echo '<td>' . htmlspecialchars($marks["{$subCode}_grade"]) . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo '<p>No external marks found.</p>';
                    }
                }
            } else {
                echo '<p>Invalid Roll Number or Password.</p>';
            }
        }

        $conn->close();
     
     ?>

        <div class="button-container <?= $formSubmitted ? 'hidden' : '' ?>" id="buttonContainer">
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
                <input type="submit" value="View Marks">
            </form>
        </div>

        <script>
            const actionInput = document.getElementById('action');
            const marksForm = document.getElementById('marksForm');
            const buttonContainer = document.getElementById('buttonContainer');

            function showForm(action) {
                marksForm.style.display = 'block';
                buttonContainer.classList.add('hidden');
                actionInput.value = action;
            }
        </script>
    </div>
</body>
</html>
