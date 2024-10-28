<?php
$servername = "localhost";
$username = "root";  // Adjust if needed
$password = "";      // Adjust if needed
$dbname = "ligaya_photostudio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the plain text password
$plainPassword = 'admin123'; // Replace with your current plain text password

// Hash the password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Update the hashed password in the database
$sql = "UPDATE admin_account SET password = '$hashedPassword' WHERE username = 'admin'";

if ($conn->query($sql) === TRUE) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . $conn->error;
}

$conn->close();
?>
