<?php
require_once 'config.php';

session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to index.html
header("Location: index.html");
exit();
?>