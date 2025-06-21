<?php
// Database connection configuration
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "tracking";
$port = 3306;

function openConnection() {
    global $servername, $username, $password, $dbname, $port;
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = openConnection();

// Initialize messages array
$messages = [];

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


// Debug output for troubleshooting
//  echo "Selected Subject: " . htmlspecialchars($subject) . "<br>";

if (array_key_exists($subject, $subjectTableMap)) {
    $table = $subjectTableMap[$subject];
} 
else {
    $table = null;
    echo "No table found for the selected subject.<br>";
    exit;
}

// if ($table === null) {
//     die("No table found for the selected subject.");
// }


// Handle edit action
$record = null; // Initialize record variable
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    if (!$record) {
        die("Record not found.");
    }
}

// Handle update action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $roll_no = $_POST['rollno'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $internal1 = intval($_POST['internal1'] ?? 0);
    $internal2 = intval($_POST['internal2'] ?? 0);
    $internal3 = intval($_POST['internal3'] ?? 0);
    $assignment1 = intval($_POST['assignment1'] ?? 0);
    $assignment2 = intval($_POST['assignment2'] ?? 0);
    $assignment3 = intval($_POST['assignment3'] ?? 0);
    $attendance_percentage = floatval($_POST['attendance_percentage'] ?? 0.0);

    // Update SQL query
    $sql = "UPDATE $table SET name = ?, rollno = ?, email = ?, dob = ?, internal1 = ?, 
            internal2 = ?, internal3 = ?, assignment1 = ?, assignment2 = ?, 
            assignment3 = ?, attendance_percentage = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        'ssssiissssdi',
        $name, $roll_no, $email, $dob, $internal1, $internal2, $internal3,
        $assignment1, $assignment2, $assignment3, $attendance_percentage, $id
    );
    if ($stmt->execute()) {
        $messages[] = "Record successfully updated.";
        // Reset the record variable to hide the form after update
        $record = null;
    } else {
        $messages[] = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
        $messages[] = "Record successfully deleted.";
    } else {
        $messages[] = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch records to display
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracking - Faculty Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
   <style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-image: url('Images/edit1.jpeg'); /* Replace with your image URL */
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #333;
    transition: background-color 0.3s ease;
}

.header {
    margin-bottom: 20px;
    background-color: rgba(255, 255, 255, 0.9); /* Slightly more transparent */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.header h1, .header p {
    margin: 5px 0;
    color: #333;
    font-weight: bold;
}

.dashboard-link {
    text-align: right;
    margin-bottom: 20px;
}

.dashboard-link a {
    text-decoration: none;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease;
}

.dashboard-link a:hover {
    background-color: #0056b3;
}

h2 {
    text-align: center;
    background-color: rgba(255, 255, 255, 0.9);
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
    font-weight: bold;
}

table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }
    
    /* Header Styling */
    th {
        background-color: #004080; /* Dark Blue */
        color: white;
        font-weight: bold;
        padding: 12px;
        text-align: center;
        border: 1px solid #003366;
    }
    
    /* Row Styling */
    tr:nth-child(even) {
        background-color: #e6f0ff; /* Light Blue for alternate rows */
    }
    
    tr:nth-child(odd) {
        background-color: #ffffff; /* White for alternate rows */
    }
    
    /* Cell Styling */
    td {
        padding: 10px;
        text-align: center;
        border: 1px solid #99c2ff; /* Soft Blue Border */
        color: #004080; /* Text Color */
    }

    /* Hover Effect */
    tr:hover {
        background-color: #cce0ff; /* Lighter Blue on Hover */
    }

    /* Total Column Styling */
    td.total {
        font-weight: bold;
        background-color: #99c2ff; /* Mid-tone Blue for emphasis */
    }
.form-container {
    display: none;
    margin-top: 20px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.5s ease-in-out;
}

.form-container.active {
    display: block;
    animation: slide-in 0.5s ease;
}

@keyframes slide-in {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

input[type="text"], input[type="email"], input[type="date"], input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="number"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

button {
    display: inline-block;
    padding: 12px 24px;
    margin-top: 15px;
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transition: background-color 0.3s ease, transform 0.1s ease;
}

button:hover {
    background-color: #218838;
    transform: scale(1.02);
}

.actions .edit, .actions .delete {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.actions .delete {
    color: #dc3545;
}

.actions .edit:hover, .actions .delete:hover {
    color: #0056b3;
    text-decoration: underline;
}
</style>

</head>

</head>
<body>

<div class="header">
        <h1>Academic Performance Tracking</h1>
    </div>

    <div class="dashboard-link">
        <a href="faculty_marksheet_old.php">Faculty Dashboard</a>
    </div>

<!-- Display the edit form only when $record is set -->
<?php if ($record): ?>
    <div class="form-container active">
        <h2>Edit Student Record</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($record['id']); ?>">
            <table>
                <tr><td>Roll No</td><td><input type="text" id="rollno" name="rollno" value="<?php echo htmlspecialchars($record['rollno']); ?>" required></td></tr>
                <tr><td>Student Name</td><td><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($record['name']); ?>" required></td></tr>
                <tr><td>Email ID</td><td><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($record['email']); ?>"></td></tr>
                <tr><td>DOB</td><td><input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($record['dob']); ?>" required></td></tr>
                <tr><td>Internal 1</td><td><input type="number" id="internal1" name="internal1" value="<?php echo htmlspecialchars($record['internal1']); ?>" required></td></tr>
                <tr><td>Internal 2</td><td><input type="number" id="internal2" name="internal2" value="<?php echo htmlspecialchars($record['internal2']); ?>" required></td></tr>
                <tr><td>Internal 3</td><td><input type="number" id="internal3" name="internal3" value="<?php echo htmlspecialchars($record['internal3']); ?>" required></td></tr>
                <tr><td>Assignment 1</td><td><input type="number" id="assignment1" name="assignment1" value="<?php echo htmlspecialchars($record['assignment1']); ?>" required></td></tr>
                <tr><td>Assignment 2</td><td><input type="number" id="assignment2" name="assignment2" value="<?php echo htmlspecialchars($record['assignment2']); ?>" required></td></tr>
                <tr><td>Assignment 3</td><td><input type="number" id="assignment3" name="assignment3" value="<?php echo htmlspecialchars($record['assignment3']); ?>" required></td></tr>
                <tr><td>Attendance %</td><td><input type="number" id="attendance_percentage" name="attendance_percentage" value="<?php echo htmlspecialchars($record['attendance_percentage']); ?>" required></td></tr>
            </table>
            <button type="submit">Update Record</button>
        </form>
    </div>
    
<?php else: ?>
    <!-- Display the table only if not editing -->
    <table>
        <tr>
            <th>Roll No</th>
            <th>Student Name</th>
            <th>Email ID</th>
            <th>DOB</th>
            <th>Internal 1</th>
            <th>Internal 2</th>
            <th>Internal 3</th>
            <th>Assignment 1</th>
            <th>Assignment 2</th>
            <th>Assignment 3</th>
            <th>Attendance %</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['rollno']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['dob']); ?></td>
                <td><?php echo htmlspecialchars($row['internal1']); ?></td>
                <td><?php echo htmlspecialchars($row['internal2']); ?></td>
                <td><?php echo htmlspecialchars($row['internal3']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment1']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment2']); ?></td>
                <td><?php echo htmlspecialchars($row['assignment3']); ?></td>
                <td><?php echo htmlspecialchars($row['attendance_percentage']); ?></td>
                <td class="actions">
                <a class="edit" href="?subject=<?php echo urlencode($subject); ?>&action=edit&edit_id=<?php echo htmlspecialchars($row['id']); ?>">Edit<i class="fas fa-edit"></i></a>
                    <!-- <a class="edit" href="?action=edit&edit_id=<?php echo $row['id']; ?>">Edit <i class="fas fa-edit"></i></a> -->
                    <!-- <a class="delete" href="#" data-id="<?php echo $row['id']; ?>">Delete <i class="fas fa-trash"></i></a> -->
                    <!-- <a class="delete" href="#" data-id="<?php echo $row['id']; ?>">Delete <i class="fas fa-times"></i></a> -->
                   

                    <!-- <a class="delete" href="?subject=<?php echo urlencode($subject); ?>&action=delete&delete_id=<?php echo htmlspecialchars($row['id']); ?>" >Delete <i class="fas fa-times"></i></a> -->
                    <a class="delete" href="#" data-id="<?php echo $row['id']; ?>">Delete <i class="fas fa-times"></i></a>


                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   
    document.querySelectorAll('.delete').forEach(function(deleteLink) {
    deleteLink.addEventListener('click', function(e) {
        e.preventDefault();
        const deleteId = this.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the deletion URL with the correct parameters
                const subject = "<?php echo urlencode($subject); ?>";
                window.location.href = `?subject=${subject}&action=delete&delete_id=${deleteId}`;
            }
        });
    });
});


    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $message): ?>
            Swal.fire({
                text: "<?php echo addslashes($message); ?>",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        <?php endforeach; ?>
    <?php endif; ?>
</script>

</body>
</html>
