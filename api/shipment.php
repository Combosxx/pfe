// shipments.php
<?php
// Database connection
include 'config.php';

// Get parameters from the request
$service = $_GET['service'] ?? 'all';
$status = $_GET['status'] ?? 'all';

// Prepare SQL query based on filters
$query = "SELECT s.*, d.driver_type 
          FROM shipments s 
          JOIN drivers d ON s.driver_id = d.id 
          WHERE 1";

if ($service != 'all') {
    $query .= " AND s.service = '$service'";
}
if ($status != 'all') {
    $query .= " AND s.status = '$status'";
}

$result = mysqli_query($conn, $query);
$shipments = [];

while ($row = mysqli_fetch_assoc($result)) {
    $shipments[] = $row;
}

header('Content-Type: application/json');
echo json_encode($shipments);
?>
