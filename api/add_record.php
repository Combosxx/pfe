<?php
header('Content-Type: application/json');
include 'config.php';

$action = $_POST['action']; // Action type: 'user', 'driver', 'shipment', 'company'
$data = $_POST['data']; // JSON encoded data

switch ($action) {
    case 'user':
        $sql = "INSERT INTO Users (name, email, status) VALUES ('{$data['name']}', '{$data['email']}', '{$data['status']}')";
        break;
    case 'driver':
        $sql = "INSERT INTO Drivers (name, email, phone, service, status) VALUES ('{$data['name']}', '{$data['email']}', '{$data['phone']}', '{$data['service']}', '{$data['status']}')";
        break;
    case 'shipment':
        $sql = "INSERT INTO Shipments (customer_id, service, date, driver_type, cost, status) VALUES ('{$data['customer_id']}', '{$data['service']}', '{$data['date']}', '{$data['driver_type']}', '{$data['cost']}', '{$data['status']}')";
        break;
    case 'company':
        $sql = "INSERT INTO Companies (name, email, phone, service, status) VALUES ('{$data['name']}', '{$data['email']}', '{$data['phone']}', '{$data['service']}', '{$data['status']}')";
        break;
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => $conn->error));
}

$conn->close();
?>
