<?php
require 'config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$query = 'SELECT * FROM shipments WHERE 1=1';
$params = [];

if (!empty($data['service'])) {
    $query .= ' AND Service = ?';
    $params[] = $data['service'];
}

if (!empty($data['company'])) {
    $query .= ' AND CompanyOrDriver = ?';
    $params[] = $data['company'];
}

if (!empty($data['driver'])) {
    $query .= ' AND CompanyOrDriver = ?';
    $params[] = $data['driver'];
}

if (!empty($data['vehicle'])) {
    $query .= ' AND Vehicle = ?';
    $params[] = $data['vehicle'];
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
