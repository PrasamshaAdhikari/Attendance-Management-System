<?php
session_start();
require_once "../database/database.php";

$db = new Database();
$conn = $db->getConnection();

// Collect POST data
$name = $_POST['name'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$department = $_POST['department'] ?? '';


if (!preg_match("/^[a-zA-Z0-9._%+-]+@ioepc\.edu\.np$/", $email)) {
    echo json_encode([
        "status" => "error",
        "message" => "Only college mail addresses are allowed"
    ]);
    exit;
}
// Check for empty fields
if (empty($name) || empty($user_name) || empty($email) || empty($password) || empty($department)) {
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

// Check if email already exists
$sql = "SELECT * FROM teacher_details WHERE email = :email LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "EXISTS", "message" => "Email Address already exists"]);
    exit();
}
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Insert new teacher
$sql = "INSERT INTO teacher_details (name, user_name,email, password, department) VALUES (:name, :un,:email, :pw, :dept)";
$stmt = $conn->prepare($sql);
$success = $stmt->execute([
    'name' => $name,
    'un' => $user_name,
    'email' => $email,
    'pw' => $hashedPassword,
    'dept' => $department
]);

if ($success) {
    echo json_encode(["status" => "SUCCESS", "message" => "Registration successful!"]);
} else {
    echo json_encode(["status" => "ERROR", "message" => "Something went wrong"]);
}
?>