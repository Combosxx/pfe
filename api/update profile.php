<?php
include 'config.php'; // Database connection

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['bankName'], $data['rib'], $data['vehicleId'])) {
    $driverId = $_SESSION['driverId']; // Assuming the driver's ID is stored in the session

    $query = $db->prepare("
        UPDATE independent_driver 
        SET FirstName = ?, LastName = ?, Email = ?, PhoneNumber = ?, BankName = ?, RIB = ?, VehicleId = ?
        WHERE DriverId = ?
    ");
    
    $success = $query->execute([
        $data['firstName'], $data['lastName'], $data['email'], $data['phoneNumber'], $data['bankName'], $data['rib'], $data['vehicleId'], $driverId
    ]);

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
}
?>
