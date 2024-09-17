
<?php
// queries.php
header('Content-Type: application/json');
require_once 'config.php';

$sql = "SELECT * FROM Queries";
$result = $conn->query($sql);

$queries = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $queries[] = $row;
    }
}

echo json_encode($queries);
$conn->close();
?>
