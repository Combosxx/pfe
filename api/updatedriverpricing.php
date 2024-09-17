<?php
include 'config.php'; // Database connection

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['serviceId']) && isset($data['pricePerHour']) && isset($data['pricePerTrip'])) {
    $serviceId = $data['serviceId'];
    $pricePerHour = $data['pricePerHour'];
    $pricePerTrip = $data['pricePerTrip'];
    $driverId = 1; // This should be dynamically set based on the logged-in driver

    $query = $db->prepare("UPDATE DriverServices SET pricePerHour = ?, pricePerTrip = ? WHERE serviceId = ? AND driverId = ?");
    $success = $query->execute([$pricePerHour, $pricePerTrip, $serviceId, $driverId]);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Pricing updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update pricing"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
}
?>
