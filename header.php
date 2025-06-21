<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .header {
            position: fixed;
            top: 0;
            right: 0;
            background: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            width: 100%;
            text-align: right;
            z-index: 1000; /* Ensure header is above other content */
        }
        .header a {
            text-decoration: none;
            color: #007bff;
            margin-left: 20px;
            font-weight: bold;
        }
        .header a:hover {
            text-decoration: underline;
        }
        body {
            padding-top: 50px; /* Adjust this value based on the header height */
        }
    </style>
</head>
<body>

<div class="header">
    <a href="faculty_marksheet_old.php">Faculty Dashboard</a>
</div>

<!-- You can place your main content here -->
