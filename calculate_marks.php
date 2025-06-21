<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculated Marks - All Semesters</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
    </style>
</head>
<body>

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

if (empty($department) || empty($semester)) {
    die("Department or semester not set in session.");
}

// Define the subject mapping for each department and semester
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



$subjectMap = $departmentSubjectMap[$department][$semester] ?? null;

if (!$subjectMap) {
    die("Invalid department ($department) or semester ($semester) mapping.");
}

// Map the subject names to database columns
$columns = array_values($subjectMap);

// Query to fetch data from the relevant table
$tableName = strtolower($department) . 'sem' . $semester; // Assuming the table naming convention
$sql = "SELECT rollno, name, " . implode(', ', $columns) . " FROM $tableName";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<h2>Marks for $department Semester $semester (Out of 60)</h2>";
    echo "<table>";
    
    // Generate table headers dynamically
    echo "<tr>
            <th>Name</th>
            <th>Roll No</th>";
    
    foreach ($subjectMap as $subject => $column) {
        echo "<th>$subject (Out of 60)</th>";
    }
    echo "</tr>";

    // Prepare dynamic update statement
    $updateColumns = [];
    foreach ($subjectMap as $subject => $column) {
        $updateColumns[] = "{$column}_out_of_60 = ?"; // Correctly reference the column
    }
    
    // Complete the update SQL query
    $updateSql = "UPDATE $tableName SET " . implode(', ', $updateColumns) . " WHERE rollno = ?";
    $updateStmt = $conn->prepare($updateSql);

    while ($row = $result->fetch_assoc()) {
        $rollno = $row['rollno'];
        $name = htmlspecialchars($row['name']);
        
        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td>$rollno</td>";

        // Prepare an array to hold calculated marks for binding
        $calculatedMarks = [];

        // Calculate and store marks out of 60 for each subject
        foreach ($subjectMap as $subject => $column) {
            $calculatedMark = ($row[$column] * 60) / 100;
            $calculatedMarks[] = $calculatedMark;
            echo "<td>" . number_format($calculatedMark, 2) . "</td>";
        }

        // Append the roll number for the WHERE clause
        $calculatedMarks[] = $rollno; 

        // Bind the parameters for the update query
        $updateStmt->bind_param(str_repeat('d', count($calculatedMarks) - 1) . 's', ...$calculatedMarks);
        
        // Execute the update statement
        $updateStmt->execute();
        echo "</tr>";
    }

    echo "</table>";
    
    // Close the update statement
    $updateStmt->close();
} else {
    echo "<h2>No data available for department $department, semester $semester.</h2>";
}

$conn->close();
?>
</body>
</html>
