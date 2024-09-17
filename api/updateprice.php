<?php
// updatePricing.php

include 'config.php'; // Database connection

// Get the request data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['serviceId']) && isset($data['pricePerWeight']) && isset($data['pricePerDistance'])) {
    $serviceId = $data['serviceId'];
    $pricePerWeight = $data['pricePerWeight'];
    $pricePerDistance = $data['pricePerDistance'];

    // Update the pricing in the database
    $query = $db->prepare("UPDATE Services SET pricePerKg = ?, pricePerKm = ? WHERE serviceId = ?");
    $success = $query->execute([$pricePerWeight, $pricePerDistance, $serviceId]);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Pricing updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update pricing"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}
?>
