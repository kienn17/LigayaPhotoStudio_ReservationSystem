<?php
$host = 'localhost';
$db = 'ligaya_photostudio';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$sql = "INSERT INTO payments (customer_name, email, package, status, date) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $data['customer_name'], $data['email'], $data['package'], $data['status'], $data['date']);

if ($stmt->execute()) {
    $data['id'] = $stmt->insert_id; // Add the new ID to the data
    echo json_encode($data); // Return the new payment data
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
