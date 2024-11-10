<?php
include('db.php'); // Include your database connection

// Get the email from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email']; // Access email from the decoded JSON

if ($email) {
    // Prepare and execute the query to check if the email exists in the users table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    // Fetch the result
    $count = $stmt->fetchColumn();

    // Return the result as a JSON response
    echo json_encode(['isRegistered' => $count > 0]);
} else {
    // If no email is provided, send an error response
    echo json_encode(['isRegistered' => false]);
}
?>
