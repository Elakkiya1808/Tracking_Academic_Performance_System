<?php
session_start(); // Start session to access session variables

// Database connection
$conn = new mysqli('localhost', 'root', '', 'tracking'); // Update with your credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Retrieve department and semester from session
$department = $_SESSION['selectedDepartment'] ?? null;
$semester = $_SESSION['selectedSemester'] ?? null;
var_dump($_SESSION['selectedDepartment'], $_SESSION['selectedSemester']);

if (!$department || !$semester) {
    die("Department or semester not set.");
}

// Map department and semester to the corresponding table name
$tableMap = [
    'CSE' => [
        '1' => 'csesem1',
        '2' => 'csesem2',
        '3' => 'csesem3',
        '4' => 'csesem4',
        '5' => 'csesem5',
        '6' => 'csesem6',
        '7' => 'csesem7',
        '8' => 'csesem8',
    ],

    // EEE
    'EEE' => [
        '1' => 'eeesem1',
        '2' => 'eeesem2',
        '3' => 'eeesem3',
        '4' => 'eeesem4',
        '5' => 'eeesem5',
        '6' => 'eeesem6',
        '7' => 'eeesem7',
        '8' => 'eeesem8',
    ],

    // ECE
    'ECE' => [
        '1' => 'ecesem1',
        '2' => 'ecesem2',
        '3' => 'ecesem3',
        '4' => 'ecesem4',
        '5' => 'ecesem5',
        '6' => 'ecesem6',
        '7' => 'ecesem7',
        '8' => 'ecesem8',
    ],

    // MECH
    'MECH' => [
        '1' => 'mechsem1',
        '2' => 'mechsem2',
        '3' => 'mechsem3',
        '4' => 'mechsem4',
        '5' => 'mechsem5',
        '6' => 'mechsem6',
        '7' => 'mechsem7',
        '8' => 'mechsem8',
    ],

    // CIVIL
    'CIVIL' => [
        '1' => 'civilsem1',
        '2' => 'civilsem2',
        '3' => 'civilsem3',
        '4' => 'civilsem4',
        '5' => 'civilsem5',
        '6' => 'civilsem6',
        '7' => 'civilsem7',
        '8' => 'civilsem8',
    ],
];

$tableName = $tableMap[$department][$semester] ?? null;

if (!$tableName) {
    die("Invalid department or semester mapping.");
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $subjectCode => $marksArray) {
        if (strpos($subjectCode, '_marks') !== false) {
            foreach ($marksArray as $rollno => $mark) {
                // Extract the subject code by removing "_marks" suffix
                $subject = str_replace('_marks', '', $subjectCode);

                
                // Check if the student already has a record in the table
                $check_sql = "SELECT * FROM $tableName WHERE rollno = ?";
                $stmt = $conn->prepare($check_sql);
                $stmt->bind_param("s", $rollno);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Update existing record
                    $update_sql = "UPDATE $tableName SET $subject = ? WHERE rollno = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("is", $mark, $rollno);
                    $update_stmt->execute();
                } else {
                    // Insert new record
                    $insert_sql = "INSERT INTO $tableName (rollno, $subject) VALUES (?, ?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("si", $rollno, $mark);
                    $insert_stmt->execute();
                }
            }
        }
    }
    // After processing all marks, calculate total marks
$columns_sql = "SHOW COLUMNS FROM $tableName";
$columns_result = $conn->query($columns_sql);
$subjectColumns = [];

while ($row = $columns_result->fetch_assoc()) {
    $columnName = $row['Field'];
    // Exclude rollno, total_marks, id, created_at, and updated_at columns
    if (!in_array($columnName, ['rollno', 'total_marks', 'id', 'created_at', 'updated_at'])) {
        $subjectColumns[] = $columnName;
    }
}

// Calculate total marks for each student
if (!empty($subjectColumns)) {
    foreach ($marksArray as $rollno => $mark) { // Assuming marksArray contains roll numbers
        // Create a SUM expression for the total marks calculation
        $sumColumns = implode(' + ', $subjectColumns);
        $update_total_sql = "UPDATE $tableName SET total_marks = ($sumColumns) WHERE rollno = ?";
        
        // Use a prepared statement to execute the update for each student
        $update_stmt = $conn->prepare($update_total_sql);
        $update_stmt->bind_param("s", $rollno);
        $update_stmt->execute();
    }
}


    // Close the connection
    $stmt->close();
    $conn->close();

    // Redirect back to the add_external_marks page or display a success message
    // Redirect back to the add_external_marks page with a success status
    
    //header("Location: add_external_marks.php?status=success");
    $_SESSION['status'] = 'success';
    // Redirect back to add_external_marks.php while preserving department and semester
    header("Location: add_external_marks.php?dept=$department&sem=$semester");
    exit();

}
?>
