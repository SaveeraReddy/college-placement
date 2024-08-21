<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            text-align: center;
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 5px;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<form method="post">
    Enter Roll Number: <input type="text" name="roll_number">
    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection (update with your database credentials)
    $conn = new mysqli("localhost", "root", "", "placement");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the roll number submitted via form
    $rollno = $_POST["roll_number"];

    // Retrieve student details from the database for the given roll number
    $sql = "SELECT * FROM registrationdetails WHERE rollno = '$rollno'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Roll No</th><th>Year</th><th>Semester</th><th>Phone Number</th><th>Email</th></tr>";
        $row = $result->fetch_assoc();
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["rollno"] . "</td>";
        echo "<td>" . $row["year"] . "</td>";
        echo "<td>" . $row["sem"] . "</td>";
        echo "<td>" . $row["phno"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "No record found for the given roll number.";
    }

    $conn->close();
}
?>

</body>
</html>
