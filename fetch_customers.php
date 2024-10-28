<?php
session_start();
include 'db.php'; // Ensure this includes the correct database connection

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Prepare the SQL statement to fetch customer records, including the status field
        $stmt = $pdo->prepare("SELECT id, firstname, surname, email, phone, socmed_link, package, date, time, payment_proof, payment_method, status FROM book_record");
        $stmt->execute();
        
        // Fetch all customer records
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare response with proof URLs
        foreach ($customers as &$customer) {
            // Assuming payment_proof contains the file name and it's stored in the 'proof_of_payment' directory
            $customer['proof_url'] = basename($customer['payment_proof']); // Keep only the filename
        }

        // Return the records as JSON
        echo json_encode($customers);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
