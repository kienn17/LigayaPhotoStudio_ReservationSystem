<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['user_id'] = $user['id']; // Example session variable
            $_SESSION['username'] = $user['username'];
            echo 'Login successful!';
            // Redirect or perform other actions
        } else {
            // Invalid password
            echo 'Invalid username or password.';
        }
    } else {
        // User not found
        echo 'Invalid username or password.';
    }
}
?>
