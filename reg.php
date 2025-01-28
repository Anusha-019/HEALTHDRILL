<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";    // Replace with your database password
$dbname = "healthdrill"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $age = trim($_POST['age']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);

    // Validate input
    if (empty($fullname) || empty($age) || empty($mobile) || empty($email) || empty($address) || empty($password) || empty($confirmpassword)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } elseif ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO users (fullname, age, mobile, email, address, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissss", $fullname, $age, $mobile, $email, $address, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: Could not register. Please try again.');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>