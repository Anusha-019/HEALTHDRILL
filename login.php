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

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // Check credentials in the database
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Login successful!'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>    