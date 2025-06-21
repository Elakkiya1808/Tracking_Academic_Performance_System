<?php
// Database connection configuration
$servername = "127.0.0.1";      // Replace with your database server name
$username = "root";             // Replace with your database username
$password = "";                 // Replace with your database password
$dbname = "tracking";           // Replace with your database name
$port = 3306;                   // Replace with your database port if different

function openConnection() {
    global $servername, $username, $password, $dbname, $port;
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Open the connection
$conn = openConnection();

// Get parameters from the URL
$subject = $_GET['subject'] ?? '';

// Map subject to corresponding table name
$subjectTableMap  = [
  //CSE
'HSC3152 Professional English - I'=>'cpe1',
'MAC3151 Matrices and Calculus'=>'cmac',
'PHC3151 Engineering Physics'=>'cep',
'CYC3151 Engineering Chemistry'=>'cec',
 'CSC3151 Introduction to Computing' => 'citc',

'HSC3252 Professional English - II'=>'cpe2',
'BEC3251 Basic Electrical and Electronics Engineering'=>'cbeaee',
'MA3251 Advanced Calculus'=>'cac',
'CS3251 Data Structures'=>'cds',

'MA3354 Discrete Mathematics'=>'cdm',
 'CS3351 Digital Principles'=>'cdp',
'CS3352 Operating Systems'=>'cos',
 'CS3353 Database Systems' => 'cdbs',
 'CS3452 Theory of Computation' => 'ctoc',
        'CS3491 Artificial Intelligence' => 'cai',
         'CS3454 Web Technology'=>'cwt ',
       'CS3453 Computer Graphics'=>'ccg',
        
 'CS3591 Computer Networks' => 'ccn',
        'CS3501 Compiler Design' => 'ccd',
'CS3502 Software Engineering'=>'cse', 
'CS3503 Machine Learning' => 'cml',
'CS3504 Data Mining'=>'cdmin ',

'CCS356 Object Oriented Software Engineering'=>'coose',
 'CS3691 Embedded Systems'=>'ces', 
'CS3602 Cryptography'=>'ccrypt ',
 'CS3603 Parallel Computing'=>'cpc',
        'CS3601 Cloud Computing' => 'ccc',

'GEC3791 Human Values and Ethics'=>'chvae',
        'CS3701 Cyber Security' => 'ccs',
        'CS3702 Big Data Analytics' => 'cbda',
        'CS3704 Quantum Computing' => 'cqc',
'CS3703 Robotics'=>'cr',

'CSC3811 Project Work/Internship'=>'cpw',


   //ECE
'HSL3152 Professional English - I'=>'epe1',
'MAL3151 Matrices and Calculus'=>'eCmac',
'PHL3151 Engineering Physics'=>'eep ',
'CYL3151 Engineering Chemistry'=>'eec ',
'GEL3151 Problem Solving and Python Programming'=>'epsapp',
'GEL3152 Heritage of Tamils'=>'ehot',

'HSL3252 Professional English - II'=>'epe2',
'MAL3251 Statistics and Numerical Methods'=>'esanm',
'PHL3202 Physics for Electrical Engineering'=>'epfee',
'BEL3254 Electrical and Instrumentation Engineering'=>'eeaie',
'GEL3251 Engineering Graphics'=>'eeg',
'EC3251 Circuit Analysis'=>'eca',
'GEL3252 Tamils and Technology'=>'etat',

'MA3355 Random Processes and Linear Algebra'=>'erpala',
'CSL3353 C Programming and Data Structures'=>'ecpads',
'EC3354 Signals and Systems'=>'esas',
'EC3353 Electronic Devices and Circuits'=>'eedac',
'EC3351 Control Systems'=>'econs',
'EC3352 Digital Systems Design'=>'edsd',

'EC3452 Electromagnetic Fields'=>'eef',
'EC3401 Networks and Security'=>'enas',
'EC3451 Linear Integrated Circuits'=>'elic',
'Digital Signal Processing'=>'esp',
'EC3491 Communication Systems'=>'ecs',
'GEL3451 Environmental Sciences and Sustainability'=>'eesas',

'EC3501 Wireless Communication'=>'ewc',
'EC3552 VLSI and Chip Design'=>'evacd',
'EC3551 Transmission Lines and RF Systems'=>'etlars',

'ET3491 Embedded Systems and Applications'=>'eesaa',
'EC3601 Microcontrollers'=>'em',
'EC3602 Signal Processing and Applications'=>'espaa',
'EC3603 Mobile Computing'=>'emc',
'EC3691 Internet of Things'=>'eiot',
'EC3611 Software Development'=>'esd',


'GEL3791 Human Values and Ethics'=>'ehvae',
'EC3701 Artificial Intelligence'=>'eai',
'EC3702 Cyber Security' =>'ecybers',
'EC3703 Software Testing'=>'est',
'EC3704 Software Development Life Cycle'=>'esdlc',

'ECL3811 Project Work/Internship'=>'epw',
   
  //EEE
'HSE3152 Professional English - I'=>'eepe1',
'MAE3151 Matrices and Calculus'=>'eeCmac',
'PHE3151 Engineering Physics'=>'eeep ',
'CYE3151 Engineering Chemistry'=>'eeec ',
'GEE3151 Problem Solving and Python Programming'=>'eepsapp',
'GEE3152 Heritage of Tamils'=>'eehot',

'HSE3252 Professional English - II'=>'eepe2',
'MAE3251 Statistics and Numerical Methods'=>'eesanm',
'PHE3202 Physics for Electrical Engineering'=>'eepfee',
'BEE3255 Basic Civil and Mechanical Engineering'=>'eebcame',
'GEE3251 Engineering Graphics'=>'eeeg',
'EEE3251 Electrical Circuit Analysis'=>'eeeca',
'GEE3252 Tamils and Technology'=>'eetat',


'MA3303 Probability and Complex Functions'=>'eepacf',
'EE3301 Electromagnetic Fields'=>'eeef',
'EE3302 Digital Logic Circuits'=>'eedlc',
'EE3303 Electrical Machines-I'=>'eeem1',
'CSE3353 C Programming and Data Structures'=>'eecpads',

'GEE3451 Environmental Sciences and Sustainability'=>'eeesas',
'EE3401 Transmission and Distribution'=>'eetad',
'EE3402 Linear Integrated Circuits'=>'eelic',
'EE3403 Measurements and Instrumentation'=>'eemai',
'EE3404 Microprocessor and Microcontroller'=>'eemam',
'EE3405 Electrical Machines-II'=>'eeem2',

'EEE3811 Project Work/Internship'=>'eepw',

 //MECH 
'HSM3152 Professional English - I'=>'mpe1',
'MAM3151 Matrices and Calculus'=>'mmac',
'PHM3151 Engineering Physics'=>'meep ',
'CYM3151 Engineering Chemistry'=>'mec ',
'GEM3151 Problem Solving and Python Programming'=>'mpsapp',
'GEM3152 Heritage of Tamils'=>'mhot',

'HSM3252 Professional English - II'=>'mpe2',
'MAM3251 Statistics and Numerical Methods'=>'msanm',
'PH3251 Materials Science'=>'mms',
 'BEM3251 Basic Electrical and Electronics Engineering'=>'mbeaee',
'GEM3251 Engineering Graphics'=>'meg',
'GEM3252 Tamils and Technology'=>'mtat',
               
'MA3351 Transforms and Partial Differential Equations'=>'mtapde',
'ME3351 Engineering Mechanics'=>'mem',
'ME3391 Engineering Thermodynamics'=>'met',
'CE3391 Fluid Mechanics and Machinery'=>'mfmam',
'ME3392 Engineering Materials and Metallurgy'=>'memam',
'ME3393 Manufacturing Processes'=>'mmp',


'ME3491 Theory of Machines'=>'mtom',
'ME3451 Thermal Engineering'=>'mte',
'ME3492 Hydraulics and Pneumatics'=>'mhap',
'ME3493 Manufacturing Technology'=>'mmt',
'CE3491 Strength of Materials'=>'msom',
'GEM3451 Environmental Sciences and Sustainability'=>'mesas',

'ME3591 Design of Machine Elements'=>'mdome',
'ME3592 Metrology and Measurements'=>'mmam',

'ME3691 Heat and Mass Transfer'=>'mhamt',

'ME3791 Mechatronics and IoT'=>'mmai',
'ME3792 Computer Integrated Manufacturing'=>'mcim',
'GEM3791 Human Values and Ethics'=>'mhvae',
'GE3792 Industrial Management'=>'mim',

'MEM3811 Project Work/Internship'=>'mpw',
   
//CIVIL
'HS3152 Professional English - I'=>'cepe1',
'MA3151 Matrices and Calculus'=>'cemac',
'PH3151 Engineering Physics'=>'ceep ',
'CY3151 Engineering Chemistry'=>'ceec ',
'GE3151 Problem Solving and Python Programming'=>'cepsapp',
'GE3152 Heritage of Tamils'=>'cehot',

'HS3252 Professional English - II'=>'cepe2',
'MA3251 Statistics and Numerical Methods'=>'cesanm',
'PH3202 Physics for Civil Engineering'=>'cepfce',
'BE3255 Basic Electrical, Electronics and Instrumentation Engineering'=>'cebeeaie',
'GE3251 Engineering Graphics'=>'ceeg',
'GE3252 Tamils and Technology'=>'cetat',


'MA3351 Transforms and Partial Differential Equations'=>'cetapde',
'ME3351 Engineering Mechanics'=>'ceem',
'CE3301 Fluid Mechanics'=>'cefm',
'CE3302 Construction Materials and Technology'=>'cecmat',
'CE3303 Water Supply and Wastewater Engineering'=>'cewsawe',
'CE3351 Surveying and Levelling'=>'cesal',

'CE3401 Applied Hydraulics Engineering'=>'ceahe',
'CE3402 Strength of Materials'=>'cesom',
'CE3403 Concrete Technology'=>'cect',
'CE3404 Soil Mechanics'=>'cesm',
'CE3405 Highway and Railway Engineering'=>'cehare',
'GE3451 Environmental Sciences and Sustainability'=>'ceesas',

'CE3501 Design of Reinforced Concrete Structural Elements'=>'cedorcse',
'CE3502 Structural Analysis I'=>'cesa1',
'CE3503 Foundation Engineering'=>'cefe',

'CE3601 Design of Steel Structural Elements'=>'cedosse',
'CE3602 Structural Analysis II'=>'cesa2',
'AG3601 Engineering Geology'=>'cegeo',


'CE3701 Estimation, Costing and Valuation Engineering'=>'ceecve',
'AI3404 Hydrology and Water Resources Engineering'=>'cehawre',
'GE3791 Human Values and Ethics'=>'cehvae',
'GE3752 Total Quality Management'=>'cetqm',

'CE3811 Project Work/Internship'=>'cepw',


];


// Determine the table name based on the subject
$table = $subjectTableMap[$subject] ?? null;

if ($table === null) {
    die("No table found for the selected subject.");
}

// Fetch records to display from the dynamically determined table
$sql = "SELECT * FROM $table"; // Use the determined table name

// // Debugging: Display the SQL query
// echo "SQL Query: $sql<br>";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<?php include 'header.php'; ?>
<style>
    /* Set a full-page background image */
    body {
        background-image: url('Images/view2.avif'); /* Replace with the path to your background image */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        font-family: Arial, sans-serif;
    }

    /* Styling for the table container */
    table {
        width: 90%;
        margin: 50px auto;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Table headers */
    th {
        background-color: #004080; /* Dark Blue */
        color: white;
        padding: 10px;
        border: 1px solid #003366;
        font-weight: bold;
        text-align: center;
    }

    /* Table cells */
    td {
        padding: 8px;
        text-align: center;
        border: 1px solid #99c2ff;
        color: #004080;
    }

    /* Row styling */
    tr:nth-child(even) {
        background-color: #e6f0ff;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    /* Hover effect */
    tr:hover {
        background-color: #cce0ff;
    }
</style>


<!-- Table for viewing records -->
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Roll No</th>
            <th>Email ID</th>
            <th>DOB</th>
            <th>Internal 1</th>
            <th>Internal 2</th>
            <th>Internal 3</th>
            <th>Assignment 1</th>
            <th>Assignment 2</th>
            <th>Assignment 3</th>
            <th>Attendance (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['rollno']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['dob']); ?></td>
                <td><?php echo htmlspecialchars($row['internal1']); ?></td>
                <td><?php echo htmlspecialchars($row['internal2']); ?></td>
                <td><?php echo htmlspecialchars($row['internal3']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment1']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment2']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment3']); ?></td>
                <td><?php echo htmlspecialchars($row['attendance_percentage']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Close the connection
$conn->close();
?>
