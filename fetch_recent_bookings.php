<?php
session_start(); // Start the session

require 'db.php'; // Include your database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Log the issue of missing user_id
    error_log('User not logged in: Session data is empty or does not contain user_id');
    
    // Respond with a JSON error message
    echo json_encode(['error' => 'User not logged in']);
    exit; // Stop further execution
}

// Get the logged-in user ID from the session
$userId = $_SESSION['user_id'];

// Fetch the user's email from the database
$emailQuery = $pdo->prepare("SELECT email FROM users WHERE id = :userId");
$emailQuery->execute(['userId' => $userId]);
$userEmail = $emailQuery->fetchColumn();

if (!$userEmail) {
    // Log the issue if the email is not found
    error_log('User email not found for user_id: ' . $userId);
    
    // Respond with a JSON error message
    echo json_encode(['error' => 'User email not found']);
    exit; // Stop further execution
}

// Log the fetched email for debugging
error_log('User Email: ' . $userEmail);

// Fetch recent bookings for the logged-in user based on their email
$stmt = $pdo->prepare("SELECT * FROM book_record WHERE email = :email");
$stmt->execute(['email' => $userEmail]);
$recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Log the fetched bookings for debugging
error_log('Fetched Bookings: ' . print_r($recentBookings, true));

// Respond with the bookings data or a message if no bookings are found
if (empty($recentBookings)) {
    echo json_encode(['message' => 'No recent bookings found.']);
} else {
    echo json_encode($recentBookings);
}
?>
