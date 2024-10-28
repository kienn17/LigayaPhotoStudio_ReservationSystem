<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ligaya_photostudio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the JSON data from the input stream
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data["username"];
    $password = $data["password"];

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in both fields']);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ?");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if ($password === $hashedPassword) {
            // Password is correct, set session and respond with success
            $_SESSION["username"] = $row["username"];
            echo json_encode(['success' => true]);
        } else {
            // Incorrect password
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
        }
    } else {
        // Username not found
        echo json_encode(['success' => false, 'message' => 'Username not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
