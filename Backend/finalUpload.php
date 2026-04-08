<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "initialFile.php";

// Check if file is uploaded
if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
    echo "<script>alert('File upload error'); window.location='index.php';</script>";
    exit();
}

// Get form data
$filename = basename($_FILES['file']['name']);
$passcode = $_POST['passcode'];
$tmp = $_FILES['file']['tmp_name'];
$expiry = $_POST['expiry'];

// Validate inputs
if (empty($filename) || empty($passcode) || empty($expiry)) {
    echo "<script>alert('All fields are required'); window.location='index.php';</script>";
    exit();
}

// Create unique file path
$target = "uploads/" . time() . "_" . $filename;

// Move file safely
if (!move_uploaded_file($tmp, $target)) {
    echo "<script>alert('File upload failed'); window.location='index.php';</script>";
    exit();
}

// Check file actually exists after moving
if (!file_exists($target)) {
    echo "<script>alert('File not saved properly'); window.location='index.php';</script>";
    exit();
}

// Set expiry time
$expiry_time = date("Y-m-d H:i:s", strtotime("+$expiry minutes"));

// Insert into database
$conn->query("INSERT INTO files (filename, filepath, expiry_time, passcode)
VALUES ('$filename', '$target', '$expiry_time', '$passcode')");

// Success message
echo "<script>alert('File Uploaded Successfully'); window.location='index.php';</script>";
?>
