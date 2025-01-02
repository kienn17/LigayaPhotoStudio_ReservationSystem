<?php
include 'db.php';

$query = "SELECT * FROM book_record";
$stmt = $pdo->prepare($query);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add proof_url to the response
foreach ($records as &$record) {
    // If payment_proof is not empty, extract the filename
    if (!empty($record['payment_proof'])) {
        $record['proof_url'] = basename($record['payment_proof']); // Extract only the filename
    } else {
        $record['proof_url'] = null; // Handle cases where there is no proof
    }
}

echo json_encode(['status' => 'success', 'records' => $records]);
?>
