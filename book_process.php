<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Log received data
    file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);
    file_put_contents('debug.log', print_r($_FILES, true), FILE_APPEND);

    // Retrieve form data
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $package = $_POST['package'];
    $socialMedia = $_POST['socialMedia'];
    $paymentMethod = $_POST['paymentMethod'];

    // Process file upload
    $paymentProof = $_FILES['paymentProof'];
    $uploadDir = 'proof_of_payment/'; // Folder to store payment proof images

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
    }

    // Validate file type (optional)
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($paymentProof['type'], $allowedFileTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']);
        exit;
    }

    // Create a unique filename to avoid overwriting
    $filename = uniqid() . '_' . basename($paymentProof['name']);
    $uploadFile = $uploadDir . $filename;

    // Attempt to move the uploaded file
    if (!move_uploaded_file($paymentProof['tmp_name'], $uploadFile)) {
        echo json_encode(['success' => false, 'message' => 'File upload failed.']);
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'ligaya_photostudio');

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO book_record (firstname, surname, email, phone, date, time, package, socmed_link, payment_method, payment_proof) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $firstName, $surname, $email, $phone, $date, $time, $package, $socialMedia, $paymentMethod, $uploadFile);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking completed successfully!']);
    } else {
        // Log SQL error
        file_put_contents('debug.log', "SQL Error: " . $stmt->error . PHP_EOL, FILE_APPEND);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
