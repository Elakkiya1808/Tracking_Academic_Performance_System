<?php
// calculate_grade.php

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "tracking"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample mapping for departments and semesters
$departmentSemesterMap = [
    'CSE' => [
        '1' => [
            'HS3152 Professional English - I' => 'cpe1',
            'MA3151 Matrices and Calculus' => 'cmac',
            'PH3151 Engineering Physics' => 'cep',
            'CY3151 Engineering Chemistry' => 'cec',
            'CS3151 Introduction to Computing' => 'citc',
        ],
        '2' => [
            // Define other subjects here
        ],
    ],
    'ECE' => [
        // Define subjects here
    ],
];

session_start(); // Start session to use session variables

// Check if department and semester are set via GET and store in session
if (isset($_GET['dept']) && isset($_GET['sem'])) {
    $_SESSION['department'] = $_GET['dept'];
    $_SESSION['semester'] = $_GET['sem'];
}

// Use session variables for department and semester
$selectedDepartment = $_SESSION['department'] ?? '';
$selectedSemester = $_SESSION['semester'] ?? '';

// Get subjects for selected department and semester
$subjects = $departmentSemesterMap[$selectedDepartment][$selectedSemester] ?? [];

// Function to determine grade based on total marks
function determine_grade($total_marks) {
    if ($total_marks > 90) {
        return 'O';
    } elseif ($total_marks > 80) {
        return 'A+';
    } elseif ($total_marks > 70) {
        return 'A';
    } elseif ($total_marks > 60) {
        return 'B+';
    } elseif ($total_marks > 50) {
        return 'B';
    } elseif ($total_marks >= 45) {
        return 'C';
    } else {
        return 'ARREAR';
    }
}

// Build SQL query dynamically based on subjects
$subjectColumns = array_map(function($code) {
    return "{$code}_total_marks";
}, $subjects);

$subjectColumnsString = implode(", ", $subjectColumns);

// Select total marks from the view grades table
$view_grades_table = strtolower($selectedDepartment) . 'sem' . $selectedSemester . '_view_grades';
$sql_grades = "SELECT rollno, name, $subjectColumnsString FROM $view_grades_table";
$result_grades = $conn->query($sql_grades);

// Prepare to insert into calculate_grade table
while ($row = $result_grades->fetch_assoc()) {

    $rollno = $conn->real_escape_string($row['rollno']);
    $name = $conn->real_escape_string($row['name']);

    // Generate grades and total marks dynamically
    $grades = [];
    foreach ($subjects as $subjectName => $code) {
        $totalMarks = $row["{$code}_total_marks"] ?? 0;  // Default to 0 if not set
        $grade = determine_grade($totalMarks);
        $grades[$code] = [
            'total_marks' => $totalMarks,
            'grade' => $grade
        ];
    }

    // Define the calculate grade table name dynamically
    $calculate_grade_table = strtolower($selectedDepartment) . 'sem' . $selectedSemester . '_calculate_grade';
    
    // Check if the entry already exists in calculate_grade
    $check_sql = "SELECT * FROM $calculate_grade_table WHERE rollno = '$rollno'";
    $check_result = $conn->query($check_sql);

    // Construct insert or update query dynamically
    if ($check_result && $check_result->num_rows > 0) {
        // Update existing record
        $updateFields = [];
        foreach ($grades as $code => $data) {
            $updateFields[] = "{$code}_total_marks = '{$data['total_marks']}', {$code}_grade = '{$data['grade']}'";
        }
        $update_sql = "UPDATE $calculate_grade_table SET " . implode(", ", $updateFields) . " WHERE rollno = '$rollno'";
        if (!$conn->query($update_sql)) {
            error_log("Error updating $calculate_grade_table for roll number $rollno: " . $conn->error);
        }
    } else {
        // Insert new record
        $marksColumns = implode(", ", array_map(fn($code) => "{$code}_total_marks, {$code}_grade", array_keys($grades)));
        $marksValues = implode(", ", array_map(fn($data) => "'{$data['total_marks']}', '{$data['grade']}'", $grades));
        $insert_sql = "INSERT INTO $calculate_grade_table (rollno, name, $marksColumns) VALUES ('$rollno', '$name', $marksValues)";
        if (!$conn->query($insert_sql)) {
            error_log("Error inserting into $calculate_grade_table for roll number $rollno: " . $conn->error);
        }
    }
}
$sql_display = "SELECT * FROM $calculate_grade_table";
$result_display = $conn->query($sql_display);

// Check for errors in the SQL query
if (!$result_display) {
    die("Query failed: " . $conn->error);
}

// Debugging: print the SQL query for inspection
error_log("SQL Display Query: " . $sql_display);

// Log the number of rows fetched
if ($result_display->num_rows > 0) {
    error_log("Number of rows fetched: " . $result_display->num_rows);
} else {
    error_log("No records found in the calculate grade table.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculated Grades</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculated Grades</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Roll No</th>
                    <?php foreach ($subjects as $subjectName => $code): ?>
                        <th><?php echo htmlspecialchars($subjectName); ?> Total Marks</th>
                        <th><?php echo htmlspecialchars($subjectName); ?> Grade</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_display->num_rows > 0): ?>
                    <?php while($row = $result_display->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['rollno']); ?></td>
                            <?php foreach ($subjects as $subjectName => $code): ?>
                                <td><?php echo number_format($row["{$code}_total_marks"] ?? 0, 2); ?></td>
                                <td><?php echo htmlspecialchars($row["{$code}_grade"] ?? 'N/A'); ?></td>
                            
                                <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo (count($subjects) * 2) + 2; ?>">No grades found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
