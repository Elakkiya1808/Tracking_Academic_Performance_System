<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add External Marks - CSE Semester 4</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->
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
        .btn {
            padding: 10px 15px;
            background-color: #0056b3;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Add External Marks - CSE Semester 4</h2>

    <form id="marksForm">
        <table>
            <tr>
                <th>Name</th>
                <th>Roll No</th>
                <th>Theory of Computation</th>
                <th>Artificial Intelligence</th>
                <th>Web Technology</th>
                <th>Computer Graphics</th>
                <th>Actions</th>
            </tr>

            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'tracking'); // Update with your credentials

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from toc table and left join with csesem4 table
            $sql = "
                SELECT toc.rollno, toc.name, 
                       csesem4.theory_of_computation, csesem4.artificial_intelligence, 
                       csesem4.web_technology, csesem4.computer_graphics 
                FROM toc 
                LEFT JOIN csesem4 ON csesem4.rollno = toc.rollno
            ";
            $result = $conn->query($sql);
            
            if (!$result) {
                die("Query failed: " . $conn->error);
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rollno']) . "</td>";
                    echo "<td><input type='number' name='toc_marks[" . htmlspecialchars($row['rollno']) . "]' value='" . htmlspecialchars($row['theory_of_computation']) . "'></td>";
                    echo "<td><input type='number' name='ai_marks[" . htmlspecialchars($row['rollno']) . "]' value='" . htmlspecialchars($row['artificial_intelligence']) . "'></td>";
                    echo "<td><input type='number' name='wt_marks[" . htmlspecialchars($row['rollno']) . "]' value='" . htmlspecialchars($row['web_technology']) . "'></td>";
                    echo "<td><input type='number' name='cg_marks[" . htmlspecialchars($row['rollno']) . "]' value='" . htmlspecialchars($row['computer_graphics']) . "'></td>";
                    echo "<td>";
                    echo "<button type='button' class='action-btn edit' onclick='editMarks(\"" . htmlspecialchars($row['rollno']) . "\")'>Edit</button>";
                    echo "<button type='button' class='action-btn delete' onclick='deleteMarks(\"" . htmlspecialchars($row['rollno']) . "\")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        <button type="button" class="btn" id="submitMarks">Submit Marks</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#submitMarks').click(function() {
            // Prepare the data to be sent
            var formData = $('#marksForm').serialize();

            // Send the data using AJAX
            $.ajax({
                type: 'POST',
                url: 'submit_marks.php',
                data: formData,
                success: function(response) {
                    // Handle success response
                    alert("Marks submitted successfully!");
                    // Optionally, you can refresh the data or manipulate the DOM
                },
                error: function() {
                    alert("Error submitting marks. Please try again.");
                }
            });
        });
    });

    function editMarks(rollno) {
        // In this setup, we allow the user to directly edit the marks in the table.
        // No additional action is needed since marks are editable directly.
    }

    function deleteMarks(rollno) {
        if (confirm("Are you sure you want to delete the marks for Roll No: " + rollno + "?")) {
            // Perform the deletion using AJAX or redirect to a PHP script to handle the delete.
            alert("Deleting marks for Roll No: " + rollno);
            // Implementation of delete functionality goes here.
        }
    }
</script>

</body>
</html>
