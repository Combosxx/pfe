<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // Check if user exists
    $stmt = $conn->prepare("SELECT UserId FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId);
        $stmt->fetch();
        
        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO PasswordResetTokens (UserId, Token, TokenExpiry) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $token, $expiry);
        $stmt->execute();
        
        // Send reset link to the user's email
        $resetLink = "http://yourdomain.com/reset-password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n$resetLink";
        $headers = "From: no-reply@yourdomain.com";
        
        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found.']);
    }
    
    $stmt->close();
}

$conn->close();
?>
