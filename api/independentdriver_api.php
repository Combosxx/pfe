<?php
header('Content-Type: application/json');

include 'config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

// Handle API Requests
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            getDriver($_GET['id']);
        } else {
            getAllDrivers();
        }
        break;

    case 'POST':
        addDriver();
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT['id'])) {
            updateDriver($_PUT['id']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE['id'])) {
            deleteDriver($_DELETE['id']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request method.']);
        break;
}

// Fetch all drivers
function getAllDrivers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM independent_driver");
    $drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($drivers);
}

// Fetch specific driver by ID
function getDriver($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM independent_driver WHERE DriverId = ?");
    $stmt->execute([$id]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($driver) {
        echo json_encode($driver);
    } else {
        echo json_encode(['error' => 'Driver not found']);
    }
}

// Add a new driver
function addDriver() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['name'], $data['email'], $data['phone'], $data['vehicle_type'])) {
        echo json_encode(['error' => 'Invalid input']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO independent_driver (name, email, phone, vehicle_type) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$data['name'], $data['email'], $data['phone'], $data['vehicle_type']])) {
        echo json_encode(['message' => 'Driver added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add driver']);
    }
}

// Update driver details
function updateDriver($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("UPDATE independent_driver SET name = ?, email = ?, phone = ?, vehicle_type = ? WHERE DriverId = ?");
    if ($stmt->execute([$data['name'], $data['email'], $data['phone'], $data['vehicle_type'], $id])) {
        echo json_encode(['message' => 'Driver updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update driver']);
    }
}

// Delete a driver
function deleteDriver($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM independent_driver WHERE DriverId = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['message' => 'Driver deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete driver']);
    }
}
?>
