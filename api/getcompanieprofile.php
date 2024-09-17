<?php
include 'config.php'; // Database connection

$companyId = $_SESSION['companyId']; // Assuming the company's ID is stored in the session

$query = $db->prepare("
    SELECT 
        c.CompanyName, c.Email, c.PhoneNumber, c.Address, c.BankName, c.RIB, c.ProfileImage
    FROM 
        companies c
    WHERE 
        c.CompanyId = ?
");
$query->execute([$companyId]);

$profile = $query->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'companyName' => $profile['CompanyName'],
    'email' => $profile['Email'],
    'phoneNumber' => $profile['PhoneNumber'],
    'address' => $profile['Address'],
    'bankName' => $profile['BankName'],
    'rib' => $profile['RIB'],
    'profileImage' => $profile['ProfileImage']
]);
?>
