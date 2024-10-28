<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $full_name = $_POST["FullName"];
    $email = $_POST["Email"];
    $username = $_POST["Username"];
    $phone = $_POST["Phone"];
    $password = $_POST["Password"];
    $confirm_password = $_POST["ConfirmPassword"];

    // Check for empty fields
    if (empty($full_name) || empty($email) || empty($username) || empty($phone) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=1"); // Error 1: Missing required fields
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: signup.php?error=2"); // Error 2: Passwords do not match
        exit();
    }

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL statement to insert new user data, including plain confirm_password
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, username, password, confirm_password) VALUES (?, ?, ?, ?, ?, ?)");

        // Bind the parameters and insert data
        $stmt->execute([$full_name, $email, $phone, $username, $hashed_password, $confirm_password]); // Store confirm_password as plain text

        // Redirect to login page after successful sign-up
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Log error and redirect with error code
        error_log("Error preparing statement: " . $e->getMessage());
        header("Location: signup.php?error=3"); // Error 3: Failed to insert data into the database
        exit();
    }
}
?>
