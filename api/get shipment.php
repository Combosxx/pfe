<?php
include 'config.php'; // Database connection

$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;

if ($userId > 0) {
    $query = $db->prepare("
        SELECT s.ShipmentId, CONCAT(c.FirstName, ' ', c.LastName) AS Customer, sv.ServiceName AS Service, s.Status, s.EstimatedDeliveryDate
        FROM shipments s
        JOIN services sv ON s.ServiceId = sv.ServiceId
        JOIN customers c ON s.CustomerId = c.CustomerId
        WHERE s.CustomerId = ?
    ");
    $query->execute([$userId]);
    $shipments = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($shipments);
} else {
    echo json_encode(['error' => 'Invalid user ID']);
}
?>
