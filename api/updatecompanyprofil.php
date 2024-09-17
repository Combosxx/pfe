<?php
include 'config.php'; // Database connection

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['companyName'], $data['email'], $data['phoneNumber'], $data['address'], $data['bankName'], $data['rib'])) {
    $companyId = $_SESSION['companyId']; // Assuming the company's ID is stored in the session

    $query = $db->prepare("
        UPDATE companies 
        SET CompanyName = ?, Email = ?, PhoneNumber = ?, Address = ?, BankName = ?, RIB = ?
        WHERE CompanyId = ?
    ");
    
    $success = $query->execute([
        $data['companyName'], $data['email'], $data['phoneNumber'], $data['address'], $data['bankName'], $data['rib'], $companyId
    ]);

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
}
?>
