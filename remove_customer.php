<?php
session_start();
include 'db.php'; // Ensure this includes the correct database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $customerId = $data->id;

    if (isset($customerId) && is_numeric($customerId)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM book_record WHERE id = ?");
            $stmt->bindParam(1, $customerId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to remove the customer record.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
