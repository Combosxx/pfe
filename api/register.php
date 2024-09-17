<?php
// register.php

include 'config.php';

// Get the request data
$data = json_decode(file_get_contents("php://input"), true);

// Validate that the necessary fields are provided
if (isset($data['email']) && isset($data['password']) && isset($data['userType'])) {
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT); // Encrypt the password
    $userType = $data['userType'];

    // Additional data based on user type (can be modified to handle specific fields for each type)
    if ($userType === 'independent_driver') {
        $licenseNumber = $data['licenseNumber'];
        $vehicleType = $data['vehicleType'];
    } elseif ($userType === 'customer') {
        $address = $data['address'];
    } elseif ($userType === 'company') {
        $companyName = $data['companyName'];
        $companyRegistration = $data['companyRegistration'];
    }

    // Check if the email already exists
    $query = $db->prepare("SELECT * FROM Users WHERE email = ?");
    $query->execute([$email]);
    $existingUser = $query->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo json_encode([
            "status" => "error",
            "message" => "Email already registered"
        ]);
    } else {
        // Insert the new user into the database
        $query = $db->prepare("INSERT INTO Users (email, password, userType) VALUES (?, ?, ?)");
        $query->execute([$email, $password, $userType]);
        $userId = $db->lastInsertId();

        // Insert additional details based on user type
        if ($userType === 'independent_driver') {
            $query = $db->prepare("INSERT INTO IndependentDrivers (UserId, licenseNumber, vehicleType) VALUES (?, ?, ?)");
            $query->execute([$userId, $licenseNumber, $vehicleType]);
        } elseif ($userType === 'customer') {
            $query = $db->prepare("INSERT INTO Customers (UserId, address) VALUES (?, ?)");
            $query->execute([$userId, $address]);
        } elseif ($userType === 'company') {
            $query = $db->prepare("INSERT INTO Companies (UserId, companyName, companyRegistration) VALUES (?, ?, ?)");
            $query->execute([$userId, $companyName, $companyRegistration]);
        }

        echo json_encode([
            "status" => "success",
            "message" => "User registered successfully"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Required fields missing"
    ]);
}
?>
