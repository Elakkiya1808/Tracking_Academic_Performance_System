<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "tracking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Initialize messages array
$messages = [];
$success = false; // Track success state for SweetAlert

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rollno = $_POST['roll_no']; // Ensure this matches the input name in the form
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $internal1 = $_POST['internal1'];
    $internal2 = $_POST['internal2'];
    $internal3 = $_POST['internal3'];
    $assignment1 = $_POST['assignment1'];
    $assignment2 = $_POST['assignment2'];
    $assignment3 = $_POST['assignment3'];
    $attendance_percentage = $_POST['attendance_percentage'];
    $edit_id = $_POST['edit_id'] ?? null;

    if ($edit_id) {
        // Update existing record
        $sql = "UPDATE $table SET 
                name = ?, rollno = ?, email = ?, dob = ?, 
                internal1 = ?, internal2 = ?, internal3 = ?, 
                assignment1 = ?, assignment2 = ?, assignment3 = ?, 
                attendance_percentage = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssiiiiidi', $name, $rollno, $email, $dob, $internal1, $internal2, $internal3, $assignment1, $assignment2, $assignment3, $attendance_percentage, $edit_id);
    } else {
        // Insert new record
        $sql = "INSERT INTO $table (name, rollno, email, dob, internal1, internal2, internal3, assignment1, assignment2, assignment3, attendance_percentage) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssiiiiid', $name, $rollno, $email, $dob, $internal1, $internal2, $internal3, $assignment1, $assignment2, $assignment3, $attendance_percentage);
    }

    if ($stmt->execute()) {
        $success = true; // Set success for SweetAlert
        $messages[] = "Record successfully " . ($edit_id ? "updated" : "created");
    } else {
        $messages[] = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch existing record if editing
$edit_id = $_GET['edit_id'] ?? null;
$student = null;

if ($edit_id) {
    $stmt = $conn->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracking</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-image: url('Images/add1.avif');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #fff;
}

.header {
    text-align: center;
    color: #fff;
    margin-bottom: 20px;
}

.header h1 {
    margin: 0;
    font-size: 36px;
}

.header h2 {
    margin: 5px 0 20px;
    font-size: 24px;
    color: #d1e7dd;
}

.dashboard-link {
    text-align: center;
    margin-bottom: 20px;
}

.dashboard-link a {
    text-decoration: none;
    background-color: #800080;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.dashboard-link a:hover {
    background-color: #218838;
}

.form-container {
    width: 400px;
    margin: 0 auto;
    background-color: #4b0082;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
}

.form-container input[type="text"],
.form-container input[type="email"],
.form-container input[type="date"],
.form-container input[type="number"],
.form-container input[type="hidden"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    color: #333;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.form-container input[type="text"]:focus,
.form-container input[type="email"]:focus,
.form-container input[type="date"]:focus,
.form-container input[type="number"]:focus {
    border-color: #4b0082;
}

button {
    padding: 12px 0;
    background-color: #4b0082;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    display: block;
    margin: 20px auto 0;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

button:active {
    transform: scale(0.98);
}

    </style>
</head>
<body>

    <div class="header">
        <h1>Academic Performance Tracking</h1>
       
    </div>

    <div class="dashboard-link">
        <a href="faculty_marksheet_old.php">Back to Faculty Dashboard</a>
    </div>

    <div class="form-container">
        <form method="post" action="">
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($edit_id); ?>">
            <input type="text" name="roll_no" placeholder="Roll No" required value="<?php echo htmlspecialchars($student['rollno'] ?? ''); ?>">
            <input type="text" name="name" placeholder="Student Name" required value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>">
            <input type="email" name="email" placeholder="Email ID" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>">
            <input type="date" name="dob" placeholder="DOB" value="<?php echo htmlspecialchars($student['dob'] ?? ''); ?>">
            <input type="number" name="internal1" placeholder="Internal 1" min="0" value="<?php echo htmlspecialchars($student['internal1'] ?? ''); ?>">
            <input type="number" name="internal2" placeholder="Internal 2" min="0" value="<?php echo htmlspecialchars($student['internal2'] ?? ''); ?>">
            <input type="number" name="internal3" placeholder="Internal 3" min="0" value="<?php echo htmlspecialchars($student['internal3'] ?? ''); ?>">
            <input type="number" name="assignment1" placeholder="Assignment 1" min="0" value="<?php echo htmlspecialchars($student['assignment1'] ?? ''); ?>">
            <input type="number" name="assignment2" placeholder="Assignment 2" min="0" value="<?php echo htmlspecialchars($student['assignment2'] ?? ''); ?>">
            <input type="number" name="assignment3" placeholder="Assignment 3" min="0" value="<?php echo htmlspecialchars($student['assignment3'] ?? ''); ?>">
            <input type="number" name="attendance_percentage" placeholder="Attendance (%)" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($student['attendance_percentage'] ?? ''); ?>">
            <button type="submit">Submit</button>
        </form>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($success): ?>
                Swal.fire({
                    text: "<?php echo addslashes($messages[0]); ?>",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php elseif (!empty($messages)): ?>
                Swal.fire({
                    text: "<?php echo addslashes($messages[0]); ?>",
                    icon: "info",
                    timer: 3000,
                    showConfirmButton: false
                });
            <?php endif; ?>
        });
    </script>

</body>
</html>



<?php
$conn->close();
?>
