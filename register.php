<?php
// Establish database connection (update with your database credentials)
$conn = new mysqli("localhost", "root", "", "placement");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['name'], $_POST['rollno'], $_POST['year'], $_POST['sem'], $_POST['phonenumber'], $_POST['email'])) {
        // Assign form values to variables
        $name = $_POST['name'];
        $rollno = $_POST['rollno'];
        $year = $_POST['year'];
        $sem = $_POST['sem'];
        $phno  = $_POST['phonenumber']; // Corrected input name
        $email = $_POST['email'];

        // Prepare and execute SQL insert statement
        $stmt = $conn->prepare("INSERT INTO registrationdetails (name, rollno, year, sem, phno, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $rollno, $year, $sem, $phno , $email);
        
        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: project-login.php");
            exit(); // Ensure script stops execution after redirection
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

$conn->close();
?>
