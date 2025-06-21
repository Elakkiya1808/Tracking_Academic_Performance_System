<?php
session_start(); // Start session to use session variables

// Initialize variables to avoid undefined variable warnings
$selectedDepartment = ''; // No default department
$selectedSemester = ''; // No default semester
$semesterTable = '';

// Check if department and semester are set via GET
if (isset($_GET['dept']) && isset($_GET['sem'])) {
    $selectedDepartment = $_GET['dept'];
    $selectedSemester = $_GET['sem'];
}

// Check for the success message
if (isset($_SESSION['status']) && $_SESSION['status'] === 'success') {
    echo '<script>alert("Marks submitted successfully!");</script>';
    unset($_SESSION['status']); // Clear the message after displaying it
}
// Assuming you have $selectedDepartment and $selectedSemester variables from the URL or other source
$_SESSION['selectedDepartment'] = $selectedDepartment;
$_SESSION['selectedSemester'] = $selectedSemester;




// Define subject map for departments and semesters
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
        '3' => [
            'MA3354 Discrete Mathematics' => 'Cdm',
            'CS3351 Digital Principles' => 'Cdp',
            'CS3352 Operating Systems' => 'Cos',
            'CS3353 Database Systems' => 'Cdbs',
        ],
        '4' => [
            'CS3452 Theory of Computation' => 'Ctoc',
            'CS3491 Artificial Intelligence' => 'Cai',
            'CS3454 Web Technology' => 'Cwt',
            'CS3453 Computer Graphics' => 'Ccg',
        ],
        '5' => [
            'CS3591 Computer Networks' => 'Ccn',
            'CS3501 Compiler Design' => 'Ccd',
            'CS3502 Software Engineering' => 'Cse',
            'CS3503 Machine Learning' => 'Cml',
            'CS3504 Data Mining' => 'Cdmin',
        ],
        '6' => [
            'CCS356 Object Oriented Software Engineering' => 'Coose',
            'CS3691 Embedded Systems' => 'Ces',
            'CS3602 Cryptography' => 'Ccrypt',
            'CS3603 Parallel Computing' => 'Cpc',
            'CS3601 Cloud Computing' => 'Ccc',
        ],
        '7' => [
            'GE3791 Human Values and Ethics' => 'Chvae',
            'CS3701 Cyber Security' => 'Ccs',
            'CS3702 Big Data Analytics' => 'Cbda',
            'CS3704 Quantum Computing' => 'Cqc',
            'CS3703 Robotics' => 'Cr',
        ],
        '8' => [
            'CS3811 Project Work/Internship' => 'Cpw',
        ],
    ],
    'ECE' => [
        '1' => [
            'HS3152 Professional English - I' => 'Epe1',
            'MA3151 Matrices and Calculus' => 'ECmac',
            'PH3151 Engineering Physics' => 'Eep',
            'CY3151 Engineering Chemistry' => 'Eec',
            'GE3151 Problem Solving and Python Programming' => 'Epsapp',
            'GE3152 Heritage of Tamils' => 'Ehot',
        ],
        '2' => [
            'HS3252 Professional English - II' => 'Epe2',
            'MA3251 Statistics and Numerical Methods' => 'Esanm',
            'PH3202 Physics for Electrical Engineering' => 'Epfee',
            'BE3254 Electrical and Instrumentation Engineering' => 'Eeaie',
            'GE3251 Engineering Graphics' => 'Eeg',
            'EC3251 Circuit Analysis' => 'Eca',
            'GE3252 Tamils and Technology' => 'Etat',
        ],
        '3' => [
            'MA3355 Random Processes and Linear Algebra' => 'Erpala',
            'CS3353 C Programming and Data Structures' => 'Ecpads',
            'EC3354 Signals and Systems' => 'Esas',
            'EC3353 Electronic Devices and Circuits' => 'Eedac',
            'EC3351 Control Systems' => 'Econs',
            'EC3352 Digital Systems Design' => 'Edsd',
        ],
        '4' => [
            'EC3452 Electromagnetic Fields' => 'Eef',
            'EC3401 Networks and Security' => 'Enas',
            'EC3451 Linear Integrated Circuits' => 'Elic',
            'Digital Signal Processing' => 'Esp',
            'EC3491 Communication Systems' => 'Ecs',
            'GE3451 Environmental Sciences and Sustainability' => 'Eesas',
        ],
        '5' => [
            'EC3501 Wireless Communication' => 'Ewc',
            'EC3552 VLSI and Chip Design' => 'Evacd',
            'EC3551 Transmission Lines and RF Systems' => 'Etlars',
        ],
        '6' => [
            'ET3491 Embedded Systems and Applications' => 'Eesaa',
            'EC3601 Microcontrollers' => 'Em',
            'EC3602 Signal Processing and Applications' => 'Espaa',
            'EC3603 Mobile Computing' => 'Emc',
            'EC3691 Internet of Things' => 'Eiot',
            'EC3611 Software Development' => 'Esd',
        ],
        '7' => [
            'GE3791 Human Values and Ethics' => 'Ehvae',
            'EC3701 Artificial Intelligence' => 'Eai',
            'EC3702 Cyber Security' => 'Ecybers',
            'EC3703 Software Testing' => 'Est',
            'EC3704 Software Development Life Cycle' => 'Esdlc',
        ],
        '8' => [
            'EC3811 Project Work/Internship' => 'Epw',
        ],
    ],


    // EEE
    'EEE' => [
        '1' => [
            'HS3152 Professional English - I' => 'EEpe1',
            'MA3151 Matrices and Calculus' => 'EECmac',
            'PH3151 Engineering Physics' => 'EEep',
            'CY3151 Engineering Chemistry' => 'EEec',
            'GE3151 Problem Solving and Python Programming' => 'EEpsapp',
            'GE3152 Heritage of Tamils' => 'EEhot',
        ],
        '2' => [
            'HS3252 Professional English - II' => 'EEpe2',
            'MA3251 Statistics and Numerical Methods' => 'EEsanm',
            'PH3202 Physics for Electrical Engineering' => 'EEpfee',
            'BE3255 Basic Civil and Mechanical Engineering' => 'EEbcame',
            'GE3251 Engineering Graphics' => 'EEeg',
            'EE3251 Electrical Circuit Analysis' => 'EEeca',
            'GE3252 Tamils and Technology' => 'EEtat',
        ],
        '3' => [
            'MA3303 Probability and Complex Functions' => 'EEpacf',
            'EE3301 Electromagnetic Fields' => 'EEef',
            'EE3302 Digital Logic Circuits' => 'EEdlc',
            'EE3303 Electrical Machines-I' => 'EEem1',
            'CS3353 C Programming and Data Structures' => 'EEcpads',
        ],
        '4' => [
            'GE3451 Environmental Sciences and Sustainability' => 'EEesas',
            'EE3401 Transmission and Distribution' => 'EEtad',
            'EE3402 Linear Integrated Circuits' => 'EElic',
            'EE3403 Measurements and Instrumentation' => 'EEmai',
            'EE3404 Microprocessor and Microcontroller' => 'EEmam',
            'EE3405 Electrical Machines-II' => 'EEem2',
        ],
        '8' => [
            'EE3811 Project Work/Internship' => 'EEpw',
        ],
    ],

    // MECH
    'MECH' => [
        '1' => [
            'HS3152 Professional English - I' => 'Mpe1',
            'MA3151 Matrices and Calculus' => 'Mmac',
            'PH3151 Engineering Physics' => 'MEep',
            'CY3151 Engineering Chemistry' => 'Mec',
            'GE3151 Problem Solving and Python Programming' => 'Mpsapp',
            'GE3152 Heritage of Tamils' => 'Mhot',
        ],
        '2' => [
            'HS3252 Professional English - II' => 'Mpe2',
            'MA3251 Statistics and Numerical Methods' => 'Msanm',
            'PH3251 Materials Science' => 'Mms',
            'BE3251 Basic Electrical and Electronics Engineering' => 'Mbeaee',
            'GE3251 Engineering Graphics' => 'Meg',
            'GE3252 Tamils and Technology' => 'Mtat',
        ],
        '3' => [
            'MA3351 Transforms and Partial Differential Equations' => 'Mtapde',
            'ME3351 Engineering Mechanics' => 'Mem',
            'ME3391 Engineering Thermodynamics' => 'Met',
            'CE3391 Fluid Mechanics and Machinery' => 'Mfmam',
            'ME3392 Engineering Materials and Metallurgy' => 'Memam',
            'ME3393 Manufacturing Processes' => 'Mmp',
        ],
        '4' => [
            'ME3491 Theory of Machines' => 'Mtom',
            'ME3451 Thermal Engineering' => 'Mte',
            'ME3492 Hydraulics and Pneumatics' => 'Mhap',
            'ME3493 Manufacturing Technology' => 'Mmt',
            'CE3491 Strength of Materials' => 'Msom',
            'GE3451 Environmental Sciences and Sustainability' => 'Mesas',
        ],
        '5' => [
            'ME3591 Design of Machine Elements' => 'Mdome',
            'ME3592 Metrology and Measurements' => 'Mmam',
        ],
        '6' => [
            'ME3691 Heat and Mass Transfer' => 'Mhamt',
        ],
        '7' => [
            'ME3791 Mechatronics and IoT' => 'Mmai',
            'ME3792 Computer Integrated Manufacturing' => 'Mcim',
            'GE3791 Human Values and Ethics' => 'Mhvae',
            'GE3792 Industrial Management' => 'Mim',
        ],
        '8' => [
            'ME3811 Project Work/Internship' => 'Mpw',
        ],
    ],

    // CIVIL
    'CIVIL' => [
        '1' => [
            'HS3152 Professional English - I' => 'CEpe1',
            'MA3151 Matrices and Calculus' => 'CEmac',
            'PH3151 Engineering Physics' => 'CEep',
            'CY3151 Engineering Chemistry' => 'CEec',
            'GE3151 Problem Solving and Python Programming' => 'CEpsapp',
            'GE3152 Heritage of Tamils' => 'CEhot',
        ],
        '2' => [
            'HS3252 Professional English - II' => 'CEpe2',
            'MA3251 Statistics and Numerical Methods' => 'CEsanm',
            'PH3202 Physics for Electrical Engineering' => 'CEpfee',
            'BE3255 Basic Electrical, Electronics and Instrumentation Engineering' => 'CEbeeaie',
            'GE3251 Engineering Graphics' => 'CEeg',
            'GE3252 Tamils and Technology' => 'CEtat',
        ],
        '3' => [
            'MA3351 Transforms and Partial Differential Equations' => 'CEtapde',
            'ME3351 Engineering Mechanics' => 'CEem',
            'CE3301 Fluid Mechanics' => 'CEfm',
            'CE3302 Construction Materials and Technology' => 'CEcmat',
            'CE3303 Water Supply and Wastewater Engineering' => 'CEwsawe',
            'CE3351 Surveying and Levelling' => 'CEsal',
        ],
        '4' => [
            'CE3401 Applied Hydraulics Engineering' => 'CEahe',
            'CE3402 Strength of Materials' => 'CEsom',
            'CE3403 Concrete Technology' => 'CEct',
            'CE3404 Soil Mechanics' => 'CEsm',
            'CE3405 Highway and Railway Engineering' => 'CEhare',
            'GE3451 Environmental Sciences and Sustainability' => 'CEesas',
        ],
        '5' => [
            'CE3501 Design of Reinforced Concrete Structural Elements' => 'CEdorcse',
            'CE3502 Structural Analysis I' => 'CEsa1',
            'CE3503 Foundation Engineering' => 'CEfe',
        ],
        '6' => [
            'CE3601 Design of Steel Structural Elements' => 'CEdosse',
            'CE3602 Structural Analysis II' => 'CEsa2',
            'AG3601 Engineering Geology' => 'CEgeo',
        ],
        '7' => [
            'CE3701 Estimation, Costing and Valuation Engineering' => 'CEecve',
            'AI3404 Hydrology and Water Resources Engineering' => 'CEhawre',
            'GE3791 Human Values and Ethics' => 'CEhvae',
            'GE3752 Total Quality Management' => 'CEtqm',
        ],
        '8' => [
            'CE3811 Project Work/Internship' => 'CEpw',
        ],
    ],
];



$semesterTableMap = [
    // CSE
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


// Validate department and semester selection
if (isset($departmentSubjectMap[$selectedDepartment][$selectedSemester])) {
    $subjects = $departmentSubjectMap[$selectedDepartment][$selectedSemester];
    $semesterTable = $semesterTableMap[$selectedDepartment][$selectedSemester];
    
} else {
    $subjects = []; // Default to empty array if no match
}



// Database connection
$conn = new mysqli('localhost', 'root', '', 'tracking');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate that $semesterTable is properly set
// if (!empty($semesterTable)) {
//     // Build the SQL query
//     $selectColumns = "toc.rollno, toc.name, " . implode(', ', $subjects);
//     $sql = "SELECT $selectColumns FROM toc LEFT JOIN $semesterTable ON $semesterTable.rollno = toc.rollno";
// Define a mapping of departments to their corresponding tables
$departmentTableMap = [
    'CSE' => 'Cpe1',
    'CIVIL' => 'CEpe1',
    'ECE' => 'Epe1',
    'MECH' => 'Mpe1',
    'EEE' => 'EEpe1',
    
    // Add other departments and their corresponding tables here
];

// Get the selected department (make sure it's sanitized)
// $selectedDepartment = $_SESSION['dept']; // Assuming dept is stored in session

// Get the corresponding table for the selected department
$selectedTable = isset($departmentTableMap[$selectedDepartment]) ? $departmentTableMap[$selectedDepartment] : null;

// if (!empty($semesterTable) && $selectedTable) {
//     // Build the SQL query
//     $selectColumns = "$selectedTable.rollno, $selectedTable.name, " . implode(', ', $subjects);
//     $sql = "SELECT $selectColumns FROM $selectedTable LEFT JOIN $semesterTable ON $semesterTable.rollno = $selectedTable.rollno";
    
//     // Execute your query and handle results as needed



//     // Execute the query
//     $result = $conn->query($sql);
    

//     if (!$result) {
//         die("Query failed: " . $conn->error);
//     }
// } else {
//     die("Invalid department or semester selection.");
// }
if (!empty($semesterTable) && $selectedTable) {
    // Build the SQL query
    $selectColumns = "$selectedTable.rollno, $selectedTable.name, " . implode(', ', $subjects);
    $sql = "SELECT $selectColumns FROM $selectedTable LEFT JOIN $semesterTable ON $semesterTable.rollno = $selectedTable.rollno";
    
    // Execute your query and handle results as needed



    // Execute the query
    $result = $conn->query($sql);
    

    if (!$result) {
        die("Query failed: " . $conn->error);
    }
} else {
    die("Invalid department or semester selection.");
}
// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add External Marks </title>
    <style>
        body {
            background-image: url('Images/view1.jpeg');
            background-size: cover;
        background-position: center;
        background-attachment: fixed; 
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
  color: black;  /* text color */
  border: 1px solid black;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #001F3F;
            color: white;
        }
        tr:nth-child(even) {
        background-color: #d3d3d3;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

        
        .btn {
            padding: 10px 15px;
            background-color: #483d8b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #003d80;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit {
            background-color: #FFC107;
            color: white;
        }
        .delete {
            background-color: #DC3545;
            color: white;
        }
        .t1{
            color:white;
        }

    </style>
</head>
<body>

<div class="container">
    <h2 class="t1">Add External Marks - <?php echo htmlspecialchars($selectedDepartment); ?>- Semester <?php echo htmlspecialchars($selectedSemester); ?></h2>
    
    <!-- Remove the department and semester dropdowns, as we are getting these from the URL -->

    <form action="submit_marks.php" method="POST">
        <table>
            <tr>
                <th>Name</th>
                <th>Roll No</th>
                <?php foreach ($subjects as $subject => $code) {
                    echo "<th>" . htmlspecialchars($subject) . "</th>";
                } ?>
                <th>Actions</th>
            </tr>

            <?php if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rollno']) . "</td>";
                    
                    
                    foreach ($subjects as $subject => $code) {
                        $marks = htmlspecialchars($row[$code] ?? '');
                        echo "<td><input type='number' name='" . $code . "_marks[" . htmlspecialchars($row['rollno']) . "]' value='$marks' min='0' max='100'></td>";
                    }
                    echo "<td>";
                    echo "<button type='button' class='action-btn edit'>Edit</button>";
                    echo "<button type='button' class='action-btn delete'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='" . (count($subjects) + 3) . "'>No students found.</td></tr>";
            } ?>
        </table>
        <button type="submit" class="btn">Submit Marks</button>
        <button type="button" class="btn" onclick="calculateMarks()">Calculate</button> <!-- Calculate button -->
    </form>
</div>


<script>
    function calculateMarks() {
        window.location.href = "calculate_marks.php"; // Redirects to the calculate_marks.php page
    }

    function editMarks(rollno) {
        // Allow user to edit marks directly in the table (already editable)
    }

    function deleteMarks(rollno) {
        if (confirm("Are you sure you want to delete the marks for Roll No: " + rollno + "?")) {
            // Perform deletion logic or redirect to deletion script if necessary
            alert("Deleting marks for Roll No: " + rollno);
        }
    }
</script>

</body>
</html>