<?php
header('Content-Type: application/json');

include 'config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// Get parameters from query string
$service = $_GET['service'];
$weight = $_GET['weight'];

// Validate inputs
if (empty($service) || empty($weight) || !is_numeric($weight)) {
    echo json_encode(array("error" => "Invalid input."));
    exit;
}

// Prepare and execute SQL query
$sql = "SELECT cost_per_km, cost_per_weight FROM cost_estimates WHERE service = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $service);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(array("error" => "Service not found."));
    exit;
}

$row = $result->fetch_assoc();
$cost_per_km = $row['cost_per_km'];
$cost_per_weight = $row['cost_per_weight'];

// Close connection
$stmt->close();
$conn->close();

// Return cost estimates
echo json_encode(array(
    "cost_per_km" => $cost_per_km,
    "cost_per_weight" => $cost_per_weight
));
?>
