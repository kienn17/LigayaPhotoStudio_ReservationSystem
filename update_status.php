<?php
session_start();
include 'db.php'; // Ensure this includes the correct database connection

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Access the data from $_POST
        $customerId = isset($_POST['id']) ? $_POST['id'] : null;
        $newStatus = isset($_POST['status']) ? $_POST['status'] : null;

        // Validate that both fields are set
        if (empty($customerId) || empty($newStatus)) {
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        // Prepare the SQL statement to update the status
        $stmt = $pdo->prepare("UPDATE book_record SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':id', $customerId);

        // Execute the update query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Booking status updated']);
        } else {
            $errorInfo = $stmt->errorInfo(); // Fetch the error info
            echo json_encode(['error' => 'Failed to update booking status', 'details' => $errorInfo]);
        }
    } catch (PDOException $e) {
        // Provide detailed error information for debugging
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
