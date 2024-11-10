<?php
session_start();
require 'db.php'; // Include your database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch the user's email
$emailQuery = $pdo->prepare("SELECT email FROM users WHERE id = :userId");
$emailQuery->execute(['userId' => $userId]);
$userEmail = $emailQuery->fetchColumn();

if (!$userEmail) {
    echo json_encode(['error' => 'User email not found']);
    exit;
}

// Log the user's email for debugging
error_log('User Email: ' . $userEmail);

// Fetch recent bookings for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM book_record WHERE email = :email");
$stmt->execute(['email' => $userEmail]);
$recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Log the fetched bookings for debugging
error_log('Fetched Bookings: ' . print_r($recentBookings, true));

// Respond with the data
if (empty($recentBookings)) {
    echo json_encode(['message' => 'No recent bookings found.']);
} else {
    echo json_encode($recentBookings);
}
?>
