<?php
include 'config.php'; // Database connection

$driverId = $_GET['driverId'];

$query = $db->prepare("
    SELECT s.ShipmentId, c.CustomerName, svc.ServiceName, s.Status, s.EstimatedDeliveryDate AS Date
    FROM shipments s
    JOIN services svc ON s.ServiceId = svc.ServiceId
    JOIN customers c ON s.CustomerId = c.CustomerId
    JOIN DriverShipments ds ON s.ShipmentId = ds.ShipmentId
    WHERE ds.DriverId = ?
");
$query->execute([$driverId]);
$shipments = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($shipments);
?>
