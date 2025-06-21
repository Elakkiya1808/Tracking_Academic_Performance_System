<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Tracker</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #2b5876, #4e4376); /* Original gradient */
    background-image: url('Images/faculty_new.avif'); /* Add this line */
    background-size: cover; /* Ensures the image covers the entire viewport */
    background-position: center; /* Centers the background image */
    background-attachment: fixed; /* Keeps the image fixed when scrolling */
    padding: 20px;
    overflow-x: hidden;
    color: #333;
}


        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color:#dda0dd		;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.2s ease;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            font-weight: bold;
            color: #4e4376;
            letter-spacing: 1px;
            animation: slideDown 1s ease;
        }

        .button-container, .link-container, .subject-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        button, a {
            padding: 12px 25px;
            font-size: 16px;
            color: #fff;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            border-radius: 25px;
            text-decoration: none;
            text-align: center;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        button:hover, a:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        }

        .subject-container {
            flex-direction: column;
            align-items: center;
        }

        .subject-item {
    width: 80%;
    background: linear-gradient(to right, #6a11cb, #2575fc); /* Add gradient like semester buttons */
    color: #fff;
    padding: 12px;
    margin: 5px;
    text-align: center;
    border-radius: 25px; /* Round corners like buttons */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Same shadow as buttons */
    transition: transform 0.3s ease, background-color 0.3s ease;
}




        .subject-item a {
            display: block;
            color: #fff;
            text-decoration: none;
        }

        .subject-item:hover {
    background: linear-gradient(to right, #2575fc, #6a11cb); /* Hover effect like buttons */
    transform: scale(1.03); /* Slightly enlarge on hover */
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3); /* More prominent shadow on hover */
}

        .marks-entry {
            text-align: center;
        }

        input[type="text"] {
            padding: 12px;
            width: 100%;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
    padding: 12px 25px;
    font-size: 16px;
    color: white;
    background: linear-gradient(to right, #6a11cb, #2575fc); /* Same gradient as other buttons */
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
}

input[type="submit"]:hover {
    background: linear-gradient(to right, #2575fc, #6a11cb); /* Hover effect like other buttons */
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
}


        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


</head>
<body>
    <div class="container">
        <?php
        // Check which step of navigation we are on
        if (!isset($_GET['page'])) {
            // Default to faculty login
            $_GET['page'] = 'login';
        }
        $page = $_GET['page'];

        switch ($page) {
            case 'login': ?>
                <div class="title">Faculty Login</div>
                <form method="GET" action="">
                    <input type="hidden" name="page" value="selectYear">
                    <input type="submit" value="Login as Faculty">
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
                <div class="link-container">
                    <a href="?page=selectSemester&dept=CSE&year=<?php echo $_GET['year']; ?>">CSE</a>
                    <a href="?page=selectSemester&dept=ECE&year=<?php echo $_GET['year']; ?>">ECE</a>
                    <a href="?page=selectSemester&dept=EEE&year=<?php echo $_GET['year']; ?>">EEE</a>
                    <a href="?page=selectSemester&dept=CIVIL&year=<?php echo $_GET['year']; ?>">CIVIL</a>
                    <a href="?page=selectSemester&dept=MECH&year=<?php echo $_GET['year']; ?>">MECH</a>
                </div>
                <?php break;

            case 'selectSemester': ?>
                <div class="title">Select Semester</div>
                <div class="link-container">
                    <a href="?page=selectSubject&sem=1&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 1</a>
                    <a href="?page=selectSubject&sem=2&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 2</a>
                    <a href="?page=selectSubject&sem=3&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 3</a>
                    <a href="?page=selectSubject&sem=4&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 4</a>
                    <a href="?page=selectSubject&sem=5&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 5</a>
                    <a href="?page=selectSubject&sem=6&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 6</a>
                    <a href="?page=selectSubject&sem=7&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 7</a>
                    <a href="?page=selectSubject&sem=8&dept=<?php echo $_GET['dept']; ?>&year=<?php echo $_GET['year']; ?>">Semester 8</a>
                </div>
                <?php break;

            case 'selectSubject':
                $sem = $_GET['sem'];
                $dept = $_GET['dept'];
                $year = $_GET['year'];

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
                    // Additional departments and their subjects can be added here
                ];

                $selectedSubjects = $subjects[$dept][$sem] ?? [];
                ?>

                <div class="title">Select Subject</div>
                <div class="subject-container">
                    <?php foreach ($selectedSubjects as $subject): ?>
                        <div class="subject-item">
                            <a href="faculty_marksheet_old.php?subject=<?php echo urlencode($subject); ?>&year=<?php echo urlencode($year); ?>&dept=<?php echo urlencode($dept); ?>&sem=<?php echo urlencode($sem); ?>">
                                <?php echo htmlspecialchars($subject); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php break;

            default:
                echo "<h2>Page not found</h2>";
        }
        ?>
    </div>
</body>
</html>
