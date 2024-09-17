<?php
session_start();
include 'config.php';

$userId = $_SESSION['UserId'];

$sql = "SELECT Title, Content, CreationDate FROM UserContent WHERE UserId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[] = $row;
}

echo json_encode($content);
?>
