<?php
// login.php

include 'config.php'; // Database connection

// Get the request data (assuming it's sent via POST)
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email']) && isset($data['password']) && isset($data['role'])) {
    $email = $data['email'];
    $password = $data['password'];
    $role = $data['role'];

    // Check if user exists with the provided email and role
    $query = $db->prepare("SELECT * FROM Users WHERE email = ? AND userType = ?");
    $query->execute([$email, $role]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user" => [
                    "userId" => $user['UserId'],
                    "email" => $user['email'],
                    "userType" => $user['userType'],
                    "redirectUrl" => getRedirectUrl($user['userType']) // Redirect based on userType
                ]
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "User not found or role mismatch"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email, password, and role are required"
    ]);
}

// Helper function to get redirect URL based on user type
function getRedirectUrl($userType) {
    switch ($userType) {
        case 'admin':
            return 'admin.html';
        case 'company':
            return 'company.html';
        case 'customer':
            return 'customer.html';
        case 'independent_driver':
            return 'independent driver.html';
        default:
            return 'index.html'; // Default fallback
    }
}
?>
