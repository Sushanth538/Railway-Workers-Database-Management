<?php
// Database connection parameters
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "register"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login credentials from the form
$email = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to retrieve user data based on email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, login successful
        echo "Login successful!";
    } else {
        // Invalid password
        echo "Invalid credentials. Please try again.";
    }
} else {
    // User not found
    echo "User not found. Please try again.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
