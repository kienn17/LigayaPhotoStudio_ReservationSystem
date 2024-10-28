<?php
$host = 'localhost';
$db = 'ligaya_photostudio';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);
$paymentId = $data['id'];

$updates = [];
$params = [];
$types = '';

if (isset($data['package'])) {
    $updates[] = "package = ?";
    $params[] = $data['package'];
    $types .= 's'; // string
}

if (isset($data['status'])) {
    $updates[] = "status = ?";
    $params[] = $data['status'];
    $types .= 's'; // string
}

// Check if there are updates to be made
if (count($updates) > 0) {
    // Prepare the SQL statement
    $sql = "UPDATE payments SET " . implode(", ", $updates) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Add the payment ID to the parameters
    $params[] = $paymentId;
    $types .= 'i'; // integer

    // Bind parameters dynamically
    $stmt->bind_param($types, ...$params);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'At least one field (package or status) is required.']);
}

$conn->close();
?>
