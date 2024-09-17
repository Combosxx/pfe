<?php
header('Content-Type: application/json');
include 'config.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getUsers':
        fetchData('users');
        break;
    case 'getDrivers':
        fetchData('drivers');
        break;
    case 'getCompanies':
        fetchData('companies');
        break;
    case 'getShipments':
        fetchData('shipments');
        break;
    case 'getUserById':
        fetchById('users', $_GET['id']);
        break;
    case 'getDriverById':
        fetchById('drivers', $_GET['id']);
        break;
    case 'getCompanyById':
        fetchById('companies', $_GET['id']);
        break;
    case 'getShipmentById':
        fetchById('shipments', $_GET['id']);
        break;
    case 'addUser':
    case 'addDriver':
    case 'addCompany':
    case 'addShipment':
        addRecord($action);
        break;
    case 'updateUser':
    case 'updateDriver':
    case 'updateCompany':
    case 'updateShipment':
        updateRecord($action);
        break;
    case 'deleteUser':
    case 'deleteDriver':
    case 'deleteCompany':
    case 'deleteShipment':
        deleteRecord($action, $_GET['id']);
        break;
}

function fetchData($table) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function fetchById($table, $id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function addRecord($action) {
    global $pdo;
    $table = str_replace('add', '', $action);
    $data = json_decode(file_get_contents('php://input'), true);
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_values($data));
    echo json_encode(['message' => 'Record added successfully']);
}

function updateRecord($action) {
    global $pdo;
    $table = str_replace('update', '', $action);
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    unset($data['id']);
    $columns = array_keys($data);
    $sql = "UPDATE $table SET " . implode(' = ?, ', $columns) . ' = ? WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge(array_values($data), [$id]));
    echo json_encode(['message' => 'Record updated successfully']);
}

function deleteRecord($action, $id) {
    global $pdo;
    $table = str_replace('delete', '', $action);
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['message' => 'Record deleted successfully']);
}
?>
<?php
header('Content-Type: application/json');
require 'config.php'; // Include your database configuration file

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getUsers':
        fetchTableData('users');
        break;
    case 'getDrivers':
        fetchTableData('drivers');
        break;
    case 'getCompanies':
        fetchTableData('companies');
        break;
    case 'getShipments':
        fetchTableData('shipments');
        break;
    case 'getUserById':
    case 'getDriverById':
    case 'getCompanyById':
    case 'getShipmentById':
        fetchById($action);
        break;
    case 'addUser':
    case 'addDriver':
    case 'addCompany':
    case 'addShipment':
        addRecord($action);
        break;
    case 'updateUser':
    case 'updateDriver':
    case 'updateCompany':
    case 'updateShipment':
        updateRecord($action);
        break;
    case 'deleteUser':
    case 'deleteDriver':
    case 'deleteCompany':
    case 'deleteShipment':
        deleteRecord($action);
        break;
    default:
        echo json_encode(['message' => 'Invalid action']);
        break;
}

function fetchTableData($table) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function fetchById($action) {
    global $pdo;
    $table = strtolower(substr($action, 3, -2));
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function addRecord($action) {
    global $pdo;
    $table = strtolower(substr($action, 3));
    $data = json_decode(file_get_contents('php://input'), true);
    $fields = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(array_values($data));
    echo json_encode(['message' => $result ? 'Record added successfully' : 'Failed to add record']);
}

function updateRecord($action) {
    global $pdo;
    $table = strtolower(substr($action, 6));
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    unset($data['id']);
    $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
    $sql = "UPDATE $table SET $fields WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(array_merge(array_values($data), [$id]));
    echo json_encode(['message' => $result ? 'Record updated successfully' : 'Failed to update record']);
}

function deleteRecord($action) {
    global $pdo;
    $table = strtolower(substr($action, 6));
    $id = $_GET['id'] ?? 0;
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$id]);
    echo json_encode(['message' => $result ? 'Record deleted successfully' : 'Failed to delete record']);
}
