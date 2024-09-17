<?php
require 'config.php'; // Database connection

$service = isset($_GET['service']) ? $_GET['service'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$sql = "SELECT * FROM ";
$params = [];
$types = "";

if ($type === 'independent_driver') {
    $sql .= "independent_driver WHERE 1=1";
    if ($service) {
        $sql .= " AND service = ?";
        $params[] = $service;
        $types .= "s";
    }
} elseif ($type === 'company') {
    $sql .= "Companies WHERE 1=1";
    if ($service) {
        $sql .= " AND service = ?";
        $params[] = $service;
        $types .= "s";
    }
} else {
    $driversSql = "SELECT * FROM independent_driver WHERE 1=1";
    $companiesSql = "SELECT * FROM Companies WHERE 1=1";
    
    if ($service) {
        $driversSql .= " AND service = ?";
        $companiesSql .= " AND service = ?";
        $params[] = $service;
        $types .= "s";
    }

    $sql = "($driversSql) UNION ($companiesSql)";
}

$stmt = $conn->prepare($sql);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

echo json_encode($results);

$stmt->close();
$conn->close();
?>
