<?php
session_start();
require_once "../database/database.php";

$db = new Database();
$conn = $db->getConnection();

// Collect POST data
$name = $_POST['name'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$password = $_POST['password'] ?? '';
$department = $_POST['department'] ?? '';

// Check for empty fields
if (empty($name) || empty($user_name) || empty($password) || empty($department)) {
    echo json_encode(["status" => "EMPTY", "message" => "All fields are required"]);
    exit();
}

// Check if username already exists
$sql = "SELECT * FROM teacher_details WHERE user_name = :un LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['un' => $user_name]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "EXISTS", "message" => "Username already exists"]);
    exit();
}

// Insert new teacher
$sql = "INSERT INTO teacher_details (name, user_name, password, department) VALUES (:name, :un, :pw, :dept)";
$stmt = $conn->prepare($sql);
$success = $stmt->execute([
    'name' => $name,
    'un' => $user_name,
    'pw' => $password,
    'dept' => $department
]);

if ($success) {
    echo json_encode(["status" => "SUCCESS", "message" => "Registration successful!"]);
} else {
    echo json_encode(["status" => "ERROR", "message" => "Something went wrong"]);
}
?>