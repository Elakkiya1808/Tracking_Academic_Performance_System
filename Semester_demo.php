<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker - Admin</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* fallback color */
            background-image: url('Images/demo.avif'); /* specify the path to your image */
            background-size: cover; /* cover the entire viewport */
            background-position: center; /* center the image */
            background-repeat: no-repeat; /* do not repeat the image */
            padding: 20px;
            overflow-x: hidden;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #A67BCA; /* Violet color for the entire container */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #fff; /* Change title color to white for better contrast */
        }

        .button-container, .link-container, .subject-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        button, a {
            padding: 12px 24px;
            font-size: 18px;
            color: #fff;
            background-color: #001F3F; /* Button color */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        button:hover, a:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: translateY(-5px);
        }

        /* Change the button colors to navy blue */
        a {
            background-color: #001F3F; /* Navy blue color */
        }

        input[type="submit"] {
            padding: 12px 24px;
            font-size: 16px;
            color: white;
            background-color: #001F3F; /* Navy blue for Login as Admin */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .subject-container {
            flex-direction: column;
            align-items: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .subject-item {
            background-color: #001F3F; /* Change subject button color to navy blue */
            color: white;
            padding: 12px;
            margin: 8px;
            width: 90%;
            text-align: center;
            border: none; /* Remove border for buttons */
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer; /* Change cursor to pointer for buttons */
            transition: transform 0.3s, background-color 0.3s;
        }

        .subject-item:hover {
            transform: scale(1.05);
            background-color: #0056b3; /* Darker blue on hover */
        }

        .marks-entry {
            text-align: center;
            margin-bottom: 20px;
        }

        .external-marks-button {
            padding: 12px 24px;
            font-size: 18px;
            color: #fff;
            background-color: #001F3F; /* Change color as desired */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        .external-marks-button:hover {
            background-color: #778899; /* Darker shade on hover */
            transform: translateY(-5px);
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

</head>
<body>
    <div class="container" id="content">
        <?php
        if (!isset($_GET['page'])) {
            $_GET['page'] = 'adminLogin';
        }
        $page = $_GET['page'];

        switch ($page) {
            case 'adminLogin': ?>
                <div class="title">Admin Login</div>
                <form method="GET" action="">
                    <input type="hidden" name="page" value="selectYear">
                    <input type="submit" value="Login as Admin">
                </form>
                <?php break;

            case 'selectYear': ?>
                <div class="title">Select Academic Year</div>
                <div class="button-container">
                <a href="?page=selectDept&year=2021">2021-2025</a>
                    <a href="?page=selectDept&year=2022">2022-2026</a>
                    <a href="?page=selectDept&year=2023">2023-202</a>
                </div>
                <?php break;

            case 'selectDept': ?>
                <div class="title">Select Department</div>
                <div class="button-container">
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
                    <?php 
                    $dept = $_GET['dept']; 
                    for ($i = 1; $i <= 8; $i++): ?>
                        <a href="?page=selectSubject&sem=<?php echo $i; ?>&dept=<?php echo $dept; ?>">Semester <?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
                <?php break;

case 'selectSubject':
    $sem = $_GET['sem'];
    $dept = $_GET['dept'];

    $subjects = [
       
            'CSE' => [
                1 => ['HSC3152 Professional English - I', 'MAC3151 Matrices and Calculus', 'PHC3151 Engineering Physics', 'CYC3151 Engineering Chemistry', 'CSC3151 Introduction to Computing'],
                2 => ['HSC3252 Professional English - II', 'BEC3251 Basic Electrical and Electronics Engineering', 'MA3251 Advanced Calculus', 'CS3251 Data Structures'],
                3 => ['MA3354 Discrete Mathematics', 'CS3351 Digital Principles', 'CS3352 Operating Systems', 'CS3353 Database Systems'],
                4 => ['CS3452 Theory of Computation', 'CS3491 Artificial Intelligence', 'CS3454 Web Technology', 'CS3453 Computer Graphics'],
                5 => ['CS3591 Computer Networks', 'CS3501 Compiler Design', 'CS3502 Software Engineering', 'CS3503 Machine Learning', 'CS3504 Data Mining'],
                6 => ['CCS356 Object Oriented Software Engineering', 'CS3691 Embedded Systems', 'CS3601 Cloud Computing', 'CS3602 Cryptography', 'CS3603 Parallel Computing'],
                7 => ['GEC3791 Human Values and Ethics', 'CS3701 Cyber Security', 'CS3702 Big Data Analytics', 'CS3703 Robotics', 'CS3704 Quantum Computing'],
                8 => ['CSC3811 Project Work/Internship'],
            ],
            'ECE' => [
                1 => ['HSL3152 Professional English - I', 'MAL3151 Matrices and Calculus', 'PHL3151 Engineering Physics', 'CYL3151 Engineering Chemistry', 'GEL3151 Problem Solving and Python Programming', 'GEL3152 Heritage of Tamils'],
                2 => ['HSL3252 Professional English - II', 'MAL3251 Statistics and Numerical Methods', 'PHL3202 Physics for Electrical Engineering', 'BEL3254 Electrical and Instrumentation Engineering', 'GEL3251 Engineering Graphics', 'EC3251 Circuit Analysis', 'GEL3252 Tamils and Technology'],
                3 => ['MA3355 Random Processes and Linear Algebra', 'CSL3353 C Programming and Data Structures', 'EC3354 Signals and Systems', 'EC3353 Electronic Devices and Circuits', 'EC3351 Control Systems', 'EC3352 Digital Systems Design'],
                4 => ['EC3452 Electromagnetic Fields', 'EC3401 Networks and Security', 'EC3451 Linear Integrated Circuits', 'Digital Signal Processing', 'EC3491 Communication Systems', 'GEL3451 Environmental Sciences and Sustainability'],
                5 => ['EC3501 Wireless Communication', 'EC3552 VLSI and Chip Design', 'EC3551 Transmission Lines and RF Systems'], // Leave space for 4 more subjects
                6 => ['ET3491 Embedded Systems and Applications', 'EC3601 Microcontrollers', 'EC3602 Signal Processing and Applications', 'EC3603 Mobile Computing', 'EC3691 Internet of Things', 'EC3611 Software Development'],
                7 => ['GEL3791 Human Values and Ethics', 'EC3701 Artificial Intelligence', 'EC3702 Cyber Security', 'EC3703 Software Testing', 'EC3704 Software Development Life Cycle'],
                8 => ['ECL3811 Project Work/Internship'],
            ],
            'EEE' => [
                1 => ['HSE3152 Professional English - I', 'MAE3151 Matrices and Calculus', 'PHE3151 Engineering Physics', 'CYE3151 Engineering Chemistry', 'GEE3151 Problem Solving and Python Programming', 'GEE3152 Heritage of Tamils'],
                2 => ['HSE3252 Professional English - II', 'MAE3251 Statistics and Numerical Methods', 'PHE3202 Physics for Electrical Engineering', 'BEE3255 Basic Civil and Mechanical Engineering', 'GEE3251 Engineering Graphics', 'EEE3251 Electrical Circuit Analysis', 'GEE3252 Tamils and Technology'],
                3 => ['MA3303 Probability and Complex Functions', 'EE3301 Electromagnetic Fields', 'EE3302 Digital Logic Circuits', 'EE3303 Electrical Machines-I', 'CSE3353 C Programming and Data Structures'],
                4 => ['GEE3451 Environmental Sciences and Sustainability', 'EE3401 Transmission and Distribution', 'EE3402 Linear Integrated Circuits', 'EE3403 Measurements and Instrumentation', 'EE3404 Microprocessor and Microcontroller', 'EE3405 Electrical Machines-II'],
                5 => [], // Leave space for 7 subjects
                6 => [], // Leave space for 7 subjects
                7 => [], // Leave space for 7 subjects
                8 => ['EEE3811 Project Work/Internship'],
            ],
            'CIVIL' => [
                1 => ['HS3152 Professional English - I', 'MA3151 Matrices and Calculus', 'PH3151 Engineering Physics', 'CY3151 Engineering Chemistry', 'GE3151 Problem Solving and Python Programming', 'GE3152 Heritage of Tamils'],
                2 => ['HS3252 Professional English - II', 'MA3251 Statistics and Numerical Methods', 'PH3202 Physics for Civil Engineering', 'BE3255 Basic Electrical, Electronics and Instrumentation Engineering', 'GE3251 Engineering Graphics', 'GE3252 Tamils and Technology'],
                3 => ['MA3351 Transforms and Partial Differential Equations', 'ME3351 Engineering Mechanics', 'CE3301 Fluid Mechanics', 'CE3302 Construction Materials and Technology', 'CE3303 Water Supply and Wastewater Engineering', 'CE3351 Surveying and Levelling'],
                4 => ['CE3401 Applied Hydraulics Engineering', 'CE3402 Strength of Materials', 'CE3403 Concrete Technology', 'CE3404 Soil Mechanics', 'CE3405 Highway and Railway Engineering', 'GE3451 Environmental Sciences and Sustainability'],
                5 => ['CE3501 Design of Reinforced Concrete Structural Elements', 'CE3502 Structural Analysis I', 'CE3503 Foundation Engineering'], // Leave space for 4 more subjects
                6 => ['CE3601 Design of Steel Structural Elements', 'CE3602 Structural Analysis II', 'AG3601 Engineering Geology'], // Leave space for 5 more subjects
                7 => ['CE3701 Estimation, Costing and Valuation Engineering', 'AI3404 Hydrology and Water Resources Engineering', 'GE3791 Human Values and Ethics', 'GE3752 Total Quality Management'], // Leave space for 3 more subjects
                8 => ['CE3811 Project Work/Internship'],
            ],
            'MECH' => [
                1 => ['HSM3152 Professional English - I', 'MAM3151 Matrices and Calculus', 'PHM3151 Engineering Physics', 'CYM3151 Engineering Chemistry', 'GEM3151 Problem Solving and Python Programming', 'GEM3152 Heritage of Tamils'],
                2 => ['HSM3252 Professional English - II', 'MAM3251 Statistics and Numerical Methods', 'PH3251 Materials Science', 'BEM3251 Basic Electrical and Electronics Engineering', 'GEM3251 Engineering Graphics', 'GEM3252 Tamils and Technology'],
                3 => ['MA3351 Transforms and Partial Differential Equations', 'ME3351 Engineering Mechanics', 'ME3391 Engineering Thermodynamics', 'CE3391 Fluid Mechanics and Machinery', 'ME3392 Engineering Materials and Metallurgy', 'ME3393 Manufacturing Processes'],
                4 => ['ME3491 Theory of Machines', 'ME3451 Thermal Engineering', 'ME3492 Hydraulics and Pneumatics', 'ME3493 Manufacturing Technology', 'CE3491 Strength of Materials', 'GEM3451 Environmental Sciences and Sustainability'],
                5 => ['ME3591 Design of Machine Elements', 'ME3592 Metrology and Measurements'], // Leave space for 4 more subjects
                6 => ['ME3691 Heat and Mass Transfer'], // Leave space for 6 more subjects
                7 => ['ME3791 Mechatronics and IoT', 'ME3792 Computer Integrated Manufacturing', 'GEM3791 Human Values and Ethics', 'GE3792 Industrial Management'], // Leave space for 3 more subjects
                8 => ['MEM3811 Project Work/Internship'],
            ],
            // Add other departments similarly
        ];

  

    if (array_key_exists($dept, $subjects) && array_key_exists($sem, $subjects[$dept])) {
        $subjectList = $subjects[$dept][$sem];
    } else {
        $subjectList = [];
    }
    ?>
    <!-- Display selected Department and Semester -->
    <div class="title">Select Subject for <?php echo $dept; ?> - Semester <?php echo $sem; ?></div>
   
    <div class="subject-container">
        <?php foreach ($subjectList as $subject): ?>
            <button class="subject-item" onclick="window.location.href='admin_marks_management.php?sem=<?php echo $sem; ?>&dept=<?php echo $dept; ?>&subject=<?php echo urlencode($subject); ?>'">
                <?php echo $subject; ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div class="marks-entry">
        <a class="external-marks-button" href="add_external_marks.php?sem=<?php echo $sem; ?>&dept=<?php echo $dept; ?>">Add External Marks</a>
        <a class="external-marks-button" href="view_grade.php?sem=<?php echo $sem; ?>&dept=<?php echo $dept; ?>">View Grades</a>
    </div>
    <?php
    break;



            case 'add_external_marks': ?>
                <div class="title">Add External Marks</div>
                <!-- Add your form for adding external marks here -->
                <?php break;

            case 'view_grade': ?>
                <div class="title">View Grades</div>
                <!-- Add your form or table for viewing grades here -->
                <?php break;
        }
        ?>
    </div>
</body>
</html>
