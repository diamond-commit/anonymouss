<?php 
 include "../config/dbjson.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Try logging in properly"]);
    exit;
}

$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

// Basic validation
if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Email and password  required"]);
    exit;
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
   echo json_encode(["success"=> false, "message"=> "input correct email format"]);
   exit;
    }

$sql = "SELECT id, password FROM users WHERE lower(email) = lower(?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "DB query failed"]);
    exit;
}

if (!$stmt->execute([$email])) {
    echo json_encode(["success" => false, "message" => "DB execution failed"]);
    exit;
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (count($user) === 0) {
    echo json_encode(["success" => false, "message" => "User not found. Want to sign up?"]);
    exit;
}

if (!password_verify($password, $user["password"])) {
    echo json_encode(["success" => false, "message" => "Wrong password"]);
    exit;
}

$_SESSION["id"] = $user["id"];
echo json_encode(["success" => true, "message" => "Login successful", "redirect" => "dashboard.php"]);
?>