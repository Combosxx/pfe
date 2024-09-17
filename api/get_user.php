<?php
require 'config.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Determine user type by checking existence in tables
    $sqlDriver = "SELECT * FROM independent_driver WHERE id = ?";
    $stmtDriver = $conn->prepare($sqlDriver);
    $stmtDriver->bind_param("i", $id);
    $stmtDriver->execute();
    $resultDriver = $stmtDriver->get_result();

    if ($resultDriver->num_rows > 0) {
        // Independent Driver
        $user = $resultDriver->fetch_assoc();
        $user['role'] = 'independent_driver';
        echo json_encode($user);
    } else {
        // Check Company
        $sqlCompany = "SELECT * FROM Companies WHERE id = ?";
        $stmtCompany = $conn->prepare($sqlCompany);
        $stmtCompany->bind_param("i", $id);
        $stmtCompany->execute();
        $resultCompany = $stmtCompany->get_result();

        if ($resultCompany->num_rows > 0) {
            // Company
            $user = $resultCompany->fetch_assoc();
            $user['role'] = 'company';
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "User not found."]);
        }
    }

    $stmtDriver->close();
    $stmtCompany->close();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Invalid user ID."]);
}

$conn->close();
?>
