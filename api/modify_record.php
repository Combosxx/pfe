<?php
header('Content-Type: application/json');
include 'config.php';

$action = $_POST['action']; // Action type: 'user', 'driver', 'shipment', 'company'
$id = $_POST['id']; // Record ID
$data = $_POST['data']; // JSON encoded data

switch ($action) {
    case 'user':
        $sql = "UPDATE Users SET name='{$data['name']}', email='{$data['email']}', status='{$data['status']}' WHERE id='$id'";
        break;
    case 'driver':
        $sql = "UPDATE Drivers SET name='{$data['name']}', email='{$data['email']}', phone='{$data['phone']}', service='{$data['service']}', status='{$data['status']}' WHERE id='$id'";
        break;
    case 'shipment':
        $sql = "UPDATE Shipments SET customer_id='{$data['customer_id']}', service='{$data['service']}', date='{$data['date']}', driver_type='{$data['driver_type']}', cost='{$data['cost']}', status='{$data['status']}' WHERE id='$id'";
        break;
    case 'company':
        $sql = "UPDATE Companies SET name='{$data['name']}', email='{$data['email']}', phone='{$data['phone']}', service='{$data['service']}', status='{$data['status']}' WHERE id='$id'";
        break;
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => $conn->error));
}

$conn->close();
?>
