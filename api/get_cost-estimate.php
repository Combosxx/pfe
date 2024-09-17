<?php
// Assuming connection to database is already established in $conn

$freight_type = $_POST['freight_type'];
$start_country = $_POST['start_country'];
$end_country = $_POST['end_country'];
$weight = $_POST['weight'];

$stmt = $conn->prepare("CALL CalculateShipmentCost(?, ?, ?, ?, @costEstimate)");
$stmt->bind_param("sssd", $freight_type, $start_country, $end_country, $weight);
$stmt->execute();

// Get the result
$result = $conn->query("SELECT @costEstimate AS cost_estimate");
$row = $result->fetch_assoc();

echo json_encode(array('cost_estimate' => $row['cost_estimate']));

$stmt->close();
$conn->close();
?>
