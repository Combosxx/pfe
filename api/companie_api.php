<?php
header('Content-Type: application/json');

require 'config.php';
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
            getCompany($_GET['id']);
        } else {
            getAllCompanies();
        }
        break;

    case 'POST':
        addCompany();
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT['id'])) {
            updateCompany($_PUT['id']);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE['id'])) {
            deleteCompany($_DELETE['id']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request method.']);
        break;
}

// Fetch all companies
function getAllCompanies() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM Companies");
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($companies);
}

// Fetch specific company by ID
function getCompany($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Companies WHERE CompanyId = ?");
    $stmt->execute([$id]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($company) {
        echo json_encode($company);
    } else {
        echo json_encode(['error' => 'Company not found']);
    }
}

// Add a new company
function addCompany() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['name'], $data['email'], $data['phone'], $data['address'])) {
        echo json_encode(['error' => 'Invalid input']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO Companies (name, email, phone, address) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address']])) {
        echo json_encode(['message' => 'Company added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add company']);
    }
}

// Update company details
function updateCompany($id) {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("UPDATE Companies SET name = ?, email = ?, phone = ?, address = ? WHERE CompanyId = ?");
    if ($stmt->execute([$data['name'], $data['email'], $data['phone'], $data['address'], $id])) {
        echo json_encode(['message' => 'Company updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update company']);
    }
}

// Delete a company
function deleteCompany($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM Companies WHERE CompanyId = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(['message' => 'Company deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete company']);
    }
}
?>
