<?php
include 'config.php'; // Database connection

$driverId = $_SESSION['driverId']; // Assuming the driver's ID is stored in the session

$query = $db->prepare("
    SELECT 
        d.FirstName, d.LastName, d.Email, d.PhoneNumber, d.BankName, d.RIB, d.VehicleId, 
        v.VehicleType, v.LicensePlate, v.VehicleImage
    FROM 
        independent_driver d
    LEFT JOIN 
        vehicles v ON d.VehicleId = v.VehicleId
    WHERE 
        d.DriverId = ?
");
$query->execute([$driverId]);

$profile = $query->fetch(PDO::FETCH_ASSOC);

// Fetch all vehicles for the dropdown
$vehiclesQuery = $db->query("SELECT VehicleId, VehicleType, LicensePlate FROM vehicles");
$vehicles = $vehiclesQuery->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'firstName' => $profile['FirstName'],
    'lastName' => $profile['LastName'],
    'email' => $profile['Email'],
    'phoneNumber' => $profile['PhoneNumber'],
    'bankName' => $profile['BankName'],
    'rib' => $profile['RIB'],
    'profileImage' => $profile['VehicleImage'], // assuming this is the profile image
    'vehicleId' => $profile['VehicleId'],
    'vehicles' => $vehicles
]);
?>
