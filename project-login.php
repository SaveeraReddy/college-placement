<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('http://www.collegebatch.com/static/clg-gallery/andhra-loyola-institute-of-engineering-vijayawada-262877.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            height: 100vh;
        }

        .container {
            position: relative;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px; /* Adjust width as needed */
            margin: 0 auto; /* Center horizontally */
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .display-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .display-button {
            padding: 15px 30px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px; /* Adjust margin between buttons */
        }

        .display-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="display-buttons">
        <button class="display-button" onclick="addBookmark1()">Display</button>
        <button class="display-button" onclick="addBookmark2()">Links</button>
    </div>
    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form action="#" method="post">
                <input type="text" name="Rollno" placeholder="Roll No" required>
                <input type="password" name="Password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>

            <?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "placement";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$registration_id = $password = "";
$reg_id_err = $password_err = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving user input
    $registration_id = $_POST['Rollno']; // Corrected to match the input name
    $password = $_POST['Password']; // Corrected to match the input name

    // Query to check if registration ID matches rollno and password matches password
    $sql = "SELECT * FROM marks WHERE ROLLNO = ? AND PASSWORD = ?";

    // Prepare and check for errors
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and check for errors
    if (!$stmt->bind_param("ss", $registration_id, $password)) {
        die("Binding parameters failed: " . $stmt->error);
    }

    // Execute statement and check for errors
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // Get result and check for errors
    $result = $stmt->get_result();
    if (!$result) {
        die("Get result failed: " . $stmt->error);
    }

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch marks from the result
        $row = $result->fetch_assoc();
        // Display marks in a table
        echo "<h2>Marks</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Semester</th><th>SGPA</th><th>CGPA</th></tr>";
        echo "<tr><td>1-1</td><td>" . $row['1-1SEM/SGPA'] . "</td><td>" . $row['1-1SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>1-2</td><td>" . $row['1-2SEM/SGPA'] . "</td><td>" . $row['1-2SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>2-1</td><td>" . $row['2-1SEM/SGPA'] . "</td><td>" . $row['2-1SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>2-2</td><td>" . $row['2-2SEM/SGPA'] . "</td><td>" . $row['2-2SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>3-1</td><td>" . $row['3-1SEM/SGPA'] . "</td><td>" . $row['3-1SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>3-2</td><td>" . $row['3-2SEM/SGPA'] . "</td><td>" . $row['3-2SEM/CGPA'] . "</td></tr>";
        echo "<tr><td>AVERAGE SGPA</td><td>" . $row['AVERAGE SGPA'] . "</td><td>" . $row['AVERAGE CGPA'] . "</td></tr>";
        echo "</table>";

        // Display BACKLOGS outside of the table
        echo "<h2>Backlogs</h2>";
        echo "<p>" . $row['BACKLOGS'] . "</p>";
    } else {
        // Check if the registration ID exists in the marks table
        $check_sql = "SELECT * FROM marks WHERE ROLLNO = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $registration_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            echo "You are not registered for the placement.";
        } else {
            echo "Invalid Password.";
        }
    }
}

// Close the database connection
$conn->close();
?>

         

        </div>
    </div>

    <script>
        function addBookmark1() {
            window.location.href = 'http://localhost/project/displayreg.php';
        }
        function addBookmark2() {
            window.location.href = 'http://localhost/project/links.html';
        }
    </script>
</body>
</html>
