<?php
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $role = $_POST['role'];

    if ($role === 'independent_driver') {
        // Update Independent Driver
        $sql = "UPDATE independent_driver SET 
                    driver_name = ?, 
                    phone_number = ?, 
                    email = ?, 
                    vehicle_type = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $_POST['driver_name'], $_POST['phone_number'], $_POST['email'], $_POST['vehicle_type'], $id);
    } elseif ($role === 'company') {
        // Update Company
        $sql = "UPDATE Companies SET 
                    company_name = ?, 
                    company_address = ?, 
                    phone_number = ?, 
                    email = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $_POST['company_name'], $_POST['company_address'], $_POST['phone_number'], $_POST['email'], $id);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid user role."]);
        exit;
    }

    if ($stmt->execute()) {
        echo json_encode(["message" => "User updated successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to update user."]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}

$conn->close();
?>
