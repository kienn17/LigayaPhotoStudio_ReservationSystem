<?php
include('db.php');

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

// Check if the request is for validating user
if (isset($data['email']) && isset($data['username'])) {
    $email = $data['email'];
    $username = $data['username'];

    // Check if the user exists with this email and username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND username = :username");
    $stmt->execute(['email' => $email, 'username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User exists, allow them to proceed to password reset
        $response['success'] = true;
        $response['message'] = 'User verified. Proceed to reset your password.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid email or username.';
    }
    echo json_encode($response);
    exit;
}

// Check if the request is for resetting the password
if (isset($data['email'], $data['password'])) {
    $email = $data['email'];
    $newPassword = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the new password

    // Prepare the SQL statement to update the password
    $stmt = $pdo->prepare("UPDATE users SET password = :password, confirm_password = :confirm_password WHERE email = :email");
    $stmt->execute(['password' => $newPassword, 'confirm_password' => $newPassword, 'email' => $email]);

    if ($stmt->rowCount()) {
        $response['success'] = true;
        $response['message'] = 'Password reset successfully! You can now log in with your new password.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to reset password. Please try again.';
    }
    echo json_encode($response);
}
?>
